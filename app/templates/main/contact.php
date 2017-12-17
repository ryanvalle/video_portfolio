<?php $config['show_contact_form_header'] = false; ?>
<section class="contact-description">
	<div class="constrain text-center">
		<?php translate('contact_us_page_main'); ?>
	</div>
</section>

<section class="contact-information">
	<div class="constrain text-center">
		<div class="address">
			<?php translate('contact_us_address'); ?>
		</div>

		<div class="contacts">
			<?php translate('contact_us_info'); ?>
		</div>
	</div>

</section>

<?php include('templates/partials/_contact_form.php'); ?>