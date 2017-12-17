
<?php
	// Get Videos
	$featured_videos = get_videos('featured');
	$testimonials = get_videos('testimonials');
	$logos = get_table_list('partners', ' WHERE active=1');
	array_push($additional_scripts, 'slick.min.js');
?>
<section class="text-blob">
	<div class="constrain border-bottom">
		<p><?php translate('homepage_rwp_description'); ?></p>
	</div>
</section>

<?php if ( $featured_videos->num_rows > 0) { ?>
<section class="featured-videos">
	<div class="constrain text-center">
		<h2><?php translate('homepage_featured_video_header'); ?></h2>	
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
	<div class="text-center"><h2><?php translate('homepage_what_people_say'); ?></h2></div>
	<div class="videos constrain text-center">
		<ul>
			<?php while($video = $testimonials->fetch_assoc())
				{ ?><li class="video-select" style="background-image: url(<?php echo $video['thumbnail']; ?>)">
					<a class="video-link" data-play-type="modal" href="/video/<?php echo $video['slug']; ?>" data-title="<?php echo $video['title']; ?>" data-frame="<?php echo base64_encode($video['iframe']); ?>"></a>
				</li><?php } ?>
		</ul>
	</div>
	<div class="constrain">
		<div class="client-logos slider">
			<?php while($logo = $logos->fetch_assoc())
				{ ?><div class="slide">
					<?php if ($logo['url']) { ?><a href="<?php echo $logo['url']; ?>"><?php } ?>
						<div class="client-logo" style="background-image: url('/public/assets/logos/<?php echo $logo["logo"]; ?>')" ></div>
					<?php if ($logo['url']) { ?></a><?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>

<?php include('templates/partials/_contact_form.php'); ?>
<?php include('templates/partials/_modal.php'); ?>

<script>
	$(function() {
		var els = $('.client-logos .slide').length,
				$modal = $('#modal .modal-content');
		$('.client-logos').slick({
      slidesToShow: setSlidesVisible(els, 6),
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 4000,
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

    $('[data-play-type=modal]').on('click', function(e) {
    	e.preventDefault();
    	var code = $(this).data('frame'),
    			decodedHtml = code && atob(code);
			$modal.html(decodedHtml);
    	$('html').addClass('modal-show');
    });

    $('#modal .modal-overlay').on('click', function(e) {
    	$modal.empty();
    	$('html').removeClass('modal-show');
    })

    function setSlidesVisible(els, max) {
    	return els < max ? els : max;
    }
	})

</script>