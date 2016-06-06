<script type="text/javascript">
$(document).ready(function() {

	var finalTitleHeight = 42;
	var titleFontSize = parseInt($('#plaque-title').css('font-size').replace('px', ''));
	var titleHeight = $('#plaque-title').innerHeight();
	while(titleHeight >= finalTitleHeight) {
		titleFontSize--;
		$('#plaque-title').css('font-size', titleFontSize+'px');
		titleHeight = $('#plaque-title').innerHeight();
	}

	var finalTextHeight = 320;
	var textFontSize = parseInt($('#plaque-text').css('font-size').replace('px', ''));
	var textHeight = $('#plaque-text').innerHeight();
	while(textHeight >= finalTextHeight) {
		textFontSize--;
		$('#plaque-text').css('font-size', textFontSize+'px');
		textHeight = $('#plaque-text').innerHeight();
	}

});
</script>
<div class="view-container" role="main">
	<div id="image-div" class="image-div">
		<div id="plaque-title">
			<?php echo $title; ?>
		</div>
		<div id="plaque-text">
			<?php echo $text; ?>
		</div>
		<img id="plaque-image" src="/public/plaque.jpg" />
	</div>
</div>