<div class="container" role="main">
	<div id="main" class="center-block">
	<h1 class="text-center">List</h1>
		<?php
		foreach($plaques as $plaque) {
		?>
			<div class="row vertical-center list-row">
				<div style="width:400px;">
					<h2><?php echo $plaque['title']; ?></h2>
					<p>by <?php echo $plaque['name']; ?></p>
				</div>
				<div class="flex-1 text-right">
					<a class="btn btn-default btn-med" role="button" href="/plaque/view/<?php echo $plaque['id']; ?>/<?php echo $plaque['urlName']; ?>">
						<span class="glyphicon glyphicon-arrow-right"></span>
					</a>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>
