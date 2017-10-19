<?php
	$videos = get_videos('portfolio');
?>

<?php if ( count($videos->fetch_assoc()) > 0) { ?>
<section class="featured-videos">
	<div class="constrain filters">
		<span>Filter By:</span>	
	</div>
	<div class="videos text-center gridify">
		<ul>
		<?php while($video = $videos->fetch_assoc())
			{ ?><li class="video-select" style="background-image: url(<?php echo $video['thumbnail']; ?>)">
				<a class="video-link" href="/video/<?php echo $video['slug']; ?>" data-title="<?php echo $video['title']; ?>"></a>
			</li><?php } ?>
		</ul>
	</div>
</section>
<?php } ?>

