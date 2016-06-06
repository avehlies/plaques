<?php
	$noTitle = ($title !== false && trim($title) === "");
	$noText = ($text !== false && trim($text) === "");
	$noName = ($name !== false && trim($name) === "");
	$hasErrors = ($errors !== false && !empty($errors));
?>

<div class="container" role="main">
	<div id="main" class="center-block">
		<h1 class="text-center">Create</h1>
		<div class="alert alert-danger <?php if(!$noTitle && !$noTitle && !$noName && !$hasErrors) echo ' collapse'; ?>">
			<?php
			if($noTitle) echo "Please fill in a title.<br />";
			if($noTitle) echo "Please fill in text.<br />";
			if($noName) echo "Please fill in your name.<br />";
			if($hasErrors) {
				foreach($errors as $error) {
					$errorText = $error;
					if($errorText == "missing-input-response") {
						$errorText = "Please complete the recaptcha.";
					}
					echo $errorText . "<br />";
				}
			}
			?>
		</div>
		<?php
		echo form_open('/plaque/save');
		?>
			<div class="form-group">
				<label for="title">Title</label>
				<input name="title" type="text" class="form-control" id="title" placeholder="Title" value="<?php echo $title; ?>" maxlength="30" />
			</div>
			<div class="form-group">
				<label for="text">Plaque Text</label>
				<textarea name="text" id="text" name="text" class="form-control" rows="4" maxlength="300"><?php echo $text; ?></textarea>
			</div>
			<div class="form-group">
				<label for="name">Your Name</label>
				<input name="name" type="text" class="form-control" id="text" placeholder="Your Name" value="<?php echo $name; ?>" maxlength="50" />
			</div>
			<div class="form-group">
				<label for="g-recaptcha-response">Recaptcha</label>
				<div class="g-recaptcha" data-sitekey="<?php echo $recaptchaPublic; ?>"></div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default pull-right">Create</button>
			</div>
		<?php
		echo form_close();
		?>
	</div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>