
<?php
	// Get Videos
	$featured_videos = get_videos('featured');
	$testimonials = get_videos('testimonials');
	array_push($additional_scripts, 'slick.min.js');
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
	<div class="videos gridify text-center">
		<ul>
		<?php while($video = $featured_videos->fetch_assoc())
			{ ?><li class="video-select" style="background-image: url(<?php echo $video['thumbnail']; ?>)">
				<a class="video-link" href="/video/<?php echo $video['slug']; ?>" data-title="<?php echo $video['title']; ?>"></a>
			</li><?php } ?>
		</ul>
	</div>
</section>
<?php } ?>

<section class="what-people-say testimonial-videos gray-block section-padding">
	<div class="text-center"><h2>What People Say About Us</h2></div>
	<div class="videos constrain text-center">
		<ul>
			<?php while($video = $testimonials->fetch_assoc())
				{ ?><li class="video-select" style="background-image: url(<?php echo $video['thumbnail']; ?>)">
					<a class="video-link" data-play-type="modal" href="/video/<?php echo $video['slug']; ?>" data-title="<?php echo $video['title']; ?>"></a>
				</li><?php } ?>
		</ul>
	</div>
	<div class="constrain">
		<p> todo:: programmable logos...</p>
		<div class="client-logos slider">
			<div class="slide"><a href="#"><img src="assets/images/placeholder/vedc_placeholder.png"/></a></div>
		</div>
	</div>
</section>

<?php include('templates/partials/_contact_form.php'); ?>

<script>
	$(function() {
		var els = $('.client-logos .slide').length;
		$('.client-logos').slick({
      slidesToShow: setSlidesVisible(els, 6),
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: false,
      dots: false,
      pauseOnHover: false,
      responsive: [
	      {
	        breakpoint: 1024,
	        settings: { slidesToShow: setSlidesVisible(els, 5) }
	      }, {
	        breakpoint: 768,
	        settings: { slidesToShow: setSlidesVisible(els, 4) }
	      }, {
	        breakpoint: 600,
	        settings: { slidesToShow: setSlidesVisible(els, 2) }
	      }
      ]
    });

    function setSlidesVisible(els, max) {
    	return els < max ? els : max;
    }
	})

</script>