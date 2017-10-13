<section class="contact-form lets-get-started">
	<div class="text-center constrain">
		<h2>Let's Get Started</h2>
		<form class="contact-form-wrapper" method="POST">
			<input type="text" placeholder="Name" id="contact-form-name" required />
			<input type="tel" placeholder="Phone Number" id="contact-form-phone" required />
			<input type="text" placeholder="Company Name" id="contact-form-business" />
			<input type="email" placeholder="E-Mail" id="contact-form-email" required />
			<textarea id="contact-form-textarea" placeholder="How can we help?"></textarea>
			<div class="text-right">
				<button class="button white gold-backgrounddark-opaque to-gold-bg no-side-margin">Submit</button>
			</div>
		</form>
	</div>
</section>

<script>
	$(function() {
		$('.contact-form-wrapper').on('submit', function(e){
			e.preventDefault();
		})
	})
</script>