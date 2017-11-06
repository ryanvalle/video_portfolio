<?php
	$videos = get_videos('portfolio');
	$categories = get_categories();
?>

<?php if ( $videos->num_rows > 0) { ?>
<section class="featured-videos portfolio-index">
	<?php if ( $categories->num_rows > 0) { ?>
	<div class="constrain filters">
		<span class="gray-text">Filter By:</span>	
		<div class="text-center">
			<?php while($cat = $categories->fetch_assoc()) { ?><button class="button gray gray-border transparent-bg dark-opaque to-gold-border to-gold-text no-side-margin oneline small-padding sm-bottom-margin active-state" data-category-target="<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></button><?php } ?>
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
		var $target = $(this),
				isActive = $target.hasClass('active'),
				catIds = [];
		if (isActive) {
			$target.removeClass('active');
		} else {
			$target.addClass('active');
		}
		if ($('.filters button.active').length == 0) {
			$('.video-select').removeClass('hidden');
		} else {
			$('.video-select').addClass('hidden');
		}
		$.each($('.filters button'), function() {
			if ($(this).hasClass('active')) {
				var id = $(this).attr('data-category-target');
				catIds.push(String(id));
			}
		})

		$.each($('.video-select .video-link'), function() {
			var that = this,
					strCatIds = $(this).attr('data-categories'),
					currCatIds = strCatIds && strCatIds.split(',');
			console.log(currCatIds);
			if (currCatIds) {
				$.each(currCatIds, function(i,x) {
					if (catIds.indexOf(String(x)) >= 0) {
						$(that).parent().removeClass('hidden');
					};
				})
			}
		});
	})
</script>