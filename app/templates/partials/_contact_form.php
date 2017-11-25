<section class="contact-form lets-get-started">
	<div class="text-center constrain">
		<?php if($config['show_contact_form_header']) { ?>
			<h2>Let's Get Started</h2>
		<?php } ?>
		<form class="contact-form-wrapper">
			<input type="text" placeholder="Name" id="contact-form-name" required />
			<input type="tel" placeholder="Phone Number" id="contact-form-phone" required />
			<input type="text" placeholder="Company Name" id="contact-form-business" />
			<input type="email" placeholder="E-Mail" id="contact-form-email" required />
			<textarea id="contact-form-message" placeholder="How can we help?"></textarea>
			<div class="text-right">
				<button class="button white gold-background dark-opaque to-gold-bg no-side-margin">Submit</button>
			</form>
		</form>
	</div>
</section>

<script>
	$(function() {
		$('.contact-form-wrapper').on('submit', function(e){
			e.preventDefault();
			var $form = $(this);
			var data = {
				'name': $form.find('#contact-form-name').val(),
				'phone': $form.find('#contact-form-phone').val(),
				'business': $form.find('#contact-form-business').val(),
				'email': $form.find('#contact-form-email').val(),
				'message': $form.find('#contact-form-message').val(),
			}

			$.ajax({
				type: 'POST',
				url: '/_contact',
				data: data,
				dataType: 'json',
				beforeSend: function() {
					console.log('sending...');
				},
				success: function(resp) {
					console.log('sent');
					console.log(resp);
				},
				error: function(resp) {
					console.error('error');
					console.error(resp);
				}
			});

		})
	})
</script>