<?php
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('/', $url);
	$urlParts = array_values(array_filter($url, function($val) {
		if(trim($val) !== '') {
			return $val;
		}
	}));
	$page = null;
	if(isset($urlParts[1])) {
		$page = $urlParts[1];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Historical Markers</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
	<link rel="stylesheet" href="/public/style.css">
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body id="<?php echo $bodyId; ?>" role="document">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="/">Historical Markers</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="<?php if($page == 'create') { echo 'active'; } ?>">
					<a href="/plaque/create">Create 
					<?php
						if($page == 'create') { ?>
						<span class="sr-only">(current)</span>
						<?php
						}
					?>
					</a>
				</li>
				<li class="<?php if($page == 'list') { echo 'active'; } ?>">
					<a href="/plaque/list">List 
					<?php
						if($page == 'list') { ?>
						<span class="sr-only">(current)</span>
						<?php
						}
					?>
					</a>
				</li>
			</ul>
			<?php
			if(isset($name) && trim($name) != "") {
			?>
				<ul class="nav navbar-nav navbar-right">
					<li class="navbar-nav pull-right"><a style="cursor: default;">By: <?php echo $name; ?></a></li>
					<li class="navbar-nav pull-right" style="margin-top:12px;">
						<a href="https://twitter.com/share" class="twitter-share-button"{count} data-size="large" data-dnt="true">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</li>
				</ul>
			<?php
			}
			?>
		</div>
	</div>
</nav>
