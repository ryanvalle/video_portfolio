	<footer>
		<div class="constrain light">
			<div class="contents text-center">
				<div class="text-left half-width">
					<div class="bold">Randy Witt Productions</div>
					<div>
						<?php foreach ($navigation as $nav) { ?>
							<a class="light to-gold" href="<?php echo $nav['url']; ?>"><?php echo $nav['title']; ?></a>
						<?php } ?> 
					</div>
				</div>

				<div class="text-right half-width address-and-phone">
					<div class="address text-left">
						<span>5121 Van Nuys Blvd., Ste 222</span>
						<span>Sherman Oaks, CA 91403</span>
					</div>
					<div class="phone text-right">
						<span>T: 818.905.7777</span>
						<span>F: 818.905.6777</span>
					</div>
				</div>

			</div>
			<div class="text-center copyright">
				All Rights Reserved. &copy; <span id="copyright-year" data-year="2016"></span> Randy Witt Productions
			</div>
		</div>
	</footer>
	<?php foreach($additional_scripts as $script) {
		echo '<script src="/public/scripts/'. $script .'" type="text/javascript"></script>' ;
	}?>
	</body>
</html>	