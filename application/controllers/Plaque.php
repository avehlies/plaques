<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(getenv('CI_ENV') == 'development') {
	require_once('/var/www/html/application/third_party/ReCaptcha_autoload.php');
} else {
	require_once(APPPATH.'third_party/ReCaptcha_autoload.php');
}

class Plaque extends CI_Controller {

	private $recaptcha = null;
	private $recaptchaPublic = null;
	private $recaptchaSecret = null;

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->database();
		
		$this->recaptchaPublic = $this->config->item('recaptchaPublic');
		$this->recaptchaSecret = $this->config->item('recaptchaSecret');
		
		$this->recaptcha = new \ReCaptcha\ReCaptcha($this->recaptchaSecret);
	}

	public function index() {
		$viewData = array(
			'bodyId' => 'homepage'
		);
		$this->load->view('header', $viewData);
		$this->load->view('homepage', $viewData);
		$this->load->view('footer', $viewData);
	}

	public function myList() {
		$plaques = array();
		$viewData = array(
			'bodyId' => 'list',
			'plaques' => array()
		);

		$this->db->where('is_hidden', 0);
		$this->db->order_by('date_created', 'desc');
		$result = $this->db->get('plaques');
		if($result->num_rows() > 0) {
			$plaques = $result->result_array();
		}

		foreach($plaques as $k => $v) {
			$plaques[$k]['urlName'] = $this->toAscii($v['title'], array('.'));
		}

		$viewData['plaques'] = $plaques;
		$this->load->view('header', $viewData);
		$this->load->view('list', $viewData);
		$this->load->view('footer', $viewData);
		
	}

	public function view($id = null, $render = null) {
		$response = array();
		if(is_null($id) || !is_numeric($id)) {
			redirect('/plaque/list');
			return;
		}

		$id = (int)$id;
		$this->db->where('id', $id);
		$response = $this->db->get('plaques');
		if($response->num_rows() != 1) {
			redirect('/plaque/list');
			return;
		}

		$viewData = $response->row_array();
		$viewData['bodyId'] = 'view';

		if($render === "screenshot-render") {
			$this->load->view('screenshot-view', $viewData);
			return false;
		}

		if($viewData['is_hidden'] == 1) {
			redirect('/plaque/list');
			return;
		}

		$this->load->view('header', $viewData);
		$this->load->view('view', $viewData);
		$this->load->view('footer', $viewData);
	}

	public function create() {
		$this->load->helper('form');
		$data = $this->session->flashdata('data');

		if(is_null($data) || empty($data)) {
			$data = array(
				'title' => false,
				'text' => false,
				'name' => false,
				'errors' => false
			);
		}
		
		$viewData = $data;
		$viewData['bodyId'] = 'create';
		$viewData['recaptchaPublic'] = $this->recaptchaPublic;

		$this->load->view('header', $viewData);
		$this->load->view('create', $data);
		$this->load->view('footer', $viewData);
	}

	public function save() {
		$gRecaptchaResponse = $this->input->post('g-recaptcha-response', TRUE);
		$data = array(
			'g-recaptcha-response' => $gRecaptchaResponse,
			'title' => $this->input->post('title', TRUE),
			'text' => $this->input->post('text', TRUE),
			'name' => $this->input->post('name', TRUE),
		);

		$errors = array();
		foreach($data as $k => $v) {
			if(is_null($v) || trim($v == "")) { 
				$errors[] = $k;
			}
		}

		unset($data['g-recaptcha-response']);
		$response = $this->recaptcha->verify($gRecaptchaResponse, $_SERVER['REMOTE_ADDR']);

		if(!$response->isSuccess()) {
			$data['errors'] = $response->getErrorCodes();
		} else {
			$data['errors'] = array();
		}

		if(!empty($errors) || !empty($data['errors'])) {
			$this->session->set_flashdata('data', $data);
			redirect('/plaque/create');
			return;
		}

		unset($data['errors']);

		$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$success = $this->db->insert('plaques', $data);

		if($success) {
			$insertId = $this->db->insert_id();
			$urlName = $this->toAscii($data['title'], array('.'));
			redirect('/plaque/view/' . $insertId . '/' . $urlName);
			return;
		} else {
			$data['error'] = array_merge($data['errors'], "database-insert-error");
			$this->session->set_flashdata('data', $data);
			redirect('/plaque/create');
			return;
		}
	}

	private function toAscii($str, $replace=array(), $delimiter='-') {
		setlocale(LC_ALL, 'en_US.UTF8');
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}

}
