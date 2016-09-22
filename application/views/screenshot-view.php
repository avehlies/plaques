<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo $baseUrl; ?>/public/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	var finalTitleHeight = 42;
	var titleFontSize = parseInt($('#screenshot-plaque-title').css('font-size').replace('px', ''));
	var titleHeight = $('#screenshot-plaque-title').innerHeight();
	while(titleHeight >= finalTitleHeight) {
		titleFontSize--;
		$('#screenshot-plaque-title').css('font-size', titleFontSize+'px');
		titleHeight = $('#screenshot-plaque-title').innerHeight();
	}

	var finalTextHeight = 320;
	var textFontSize = parseInt($('#screenshot-plaque-text').css('font-size').replace('px', ''));
	var textHeight = $('#screenshot-plaque-text').innerHeight();
	while(textHeight >= finalTextHeight) {
		textFontSize--;
		$('#screenshot-plaque-text').css('font-size', textFontSize+'px');
		textHeight = $('#screenshot-plaque-text').innerHeight();
	}

});
</script>
</head>

<body>
	<input id="is_hidden" type="hidden" value="<?php echo $is_hidden; ?>" />
	<div id="screenshot">
		<div id="screenshot-plaque-title"><?php echo $title; ?></div>
		<div id="screenshot-plaque-text"><?php echo $text; ?></div>
		<img id="screenshot-plaque-image" src="<?php echo $baseUrl; ?>/public/plaque.jpg" />
	</div>
</body>
</html>