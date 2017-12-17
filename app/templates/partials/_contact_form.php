<section class="contact-form lets-get-started">
	<div class="text-center constrain">
		<?php if($config['show_contact_form_header']) { ?>
			<h2><?php translate('global_lets_get_started'); ?></h2>
		<?php } ?>
		<form class="contact-form-wrapper">
			<input type="text" placeholder="<?php translate('global_contact_us_name'); ?>" id="contact-form-name" required />
			<input type="tel" placeholder="<?php translate('global_contact_us_phone'); ?>" id="contact-form-phone" required />
			<input type="text" placeholder="<?php translate('global_contact_us_company_name'); ?>" id="contact-form-business" />
			<input type="email" placeholder="<?php translate('global_contact_us_email'); ?>" id="contact-form-email" required />
			<textarea id="contact-form-message" placeholder="<?php translate('global_contact_us_how_can_we_help'); ?>"></textarea>
			<div class="text-right">
				<button class="button white gold-background dark-opaque to-gold-bg no-side-margin"><?php translate('global_contact_us_submit'); ?></button>
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