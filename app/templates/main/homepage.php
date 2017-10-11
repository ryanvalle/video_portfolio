<?php
	// Get Videos
	$featured_videos = get_videos('featured');
	$testimonials = get_videos('testimonials');
?>
<section class="text-blob">
	<div class="constrain border-bottom">
		<p>We’re an award-winning video production company that focuses on what you want to accomplish.  Collaboration is key as we learn about you, your goals, and your audience.  Your story becomes our passion.  Whether you arrive with a deadline and a blank slate, a rough idea, event date, or full-blown ad campaign, we’ll create powerful video that captures the message and experience you want to convey.  Crafted with imagination, emotion, and years of experience, our videos engage and motivate viewers.  Let us make a difference for you.</p>
	</div>
</section>

<?php if ( count($featured_videos->fetch_assoc()) > 0) { ?>
<section class="featured-videos">
	<div class="constrain text-center">
		<h2>Clients love our creativity, collaboration, customer service, and most of all, the results</h2>	
	</div>
	<div class="videos text-center">
		<ul>
		<?php while($video = $featured_videos->fetch_assoc())
			{ ?><li class="video-select" style="background-image: url(<?php echo $video['thumbnail']; ?>)">
				<a class="video-link" href="/video/<?php echo $video['slug']; ?>" data-title="<?php echo $video['title']; ?>"></a>
			</li><?php } ?>
		</ul>
	</div>
</section>
<?php } ?>

<section class="what-people-say testimonial-videos">
	<div class="text-center"><h2>What People Say About Us</h2>
		<div class="videos constrain text-center">
			<ul>
				<?php while($video = $testimonials->fetch_assoc())
					{ ?><li class="video-select" style="background-image: url(<?php echo $video['thumbnail']; ?>)">
						<a class="video-link" data-play-type="modal" href="/video/<?php echo $video['slug']; ?>" data-title="<?php echo $video['title']; ?>"></a>
					</li><?php } ?>
			</ul>
</section>