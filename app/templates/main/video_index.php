<?php
	$videos = get_videos('portfolio');
	$categories = get_categories();
?>

<?php if ( $videos->num_rows > 0) { ?>
<section class="featured-videos">
	<?php if ( $categories->num_rows > 0) { ?>
	<div class="constrain filters">
		<span>Filter By:</span>	
		<div>
			<?php while($cat = $categories->fetch_assoc()) { ?>
				<button class="button white gold-background dark-opaque to-gold-bg no-side-margin" data-category-target="<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></button>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
	<div class="videos text-center gridify">
		<ul>
		<?php while($video = $videos->fetch_assoc())
			{ ?><li class="video-select" style="background-image: url(<?php echo $video['thumbnail']; ?>)">
				<a class="video-link" href="/video/<?php echo $video['slug']; ?>" data-title="<?php echo $video['title']; ?>" data-categories="<?php echo $video['tags']; ?>"></a>
			</li><?php } ?>
		</ul>
	</div>
</section>
<?php } ?>

<script>
	$('.filters button').on('click.filterVideos', function(e) {
		e.preventDefault();
		var catId = $(this).attr('data-category-target');
		$('.video-select').addClass('hidden');
		$.each($('.video-select .video-link'), function() {
			var strCatIds = $(this).attr('data-categories'),
					currCatIds = strCatIds && strCatIds.split(',');
			if ( currCatIds && currCatIds.indexOf(String(catId)) >= 0 ) {
				console.log($(this).parent())
				$(this).parent().removeClass('hidden');
			}
		});
	})
</script>