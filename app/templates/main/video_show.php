<section class="video-player-section constrain">
	<div class="video-player">
		<?php echo $data['iframe']; ?>
	</div>
</section>

<section class="video-info constrain">
	<h1><?php echo $data['title'] ?></h1>
	
	<?php if (!empty($data['client'])) {?>
		<span class="client light">Client: <?php echo $data['client']; ?></span>
	<?php } ?>

	<?php if (!empty($data['description'])) {?>
		<div class="description"><?php echo $data['description']; ?></div>
	<?php } ?>

	<div class="text-center padding-top-10">
		<a class="button gold transparent-bg oneline dynamic-width to-gray-bg" href="<?php echo $navigation['portfolio']['url']; ?>">Watch More Videos
		</a>
	</div>

</section>