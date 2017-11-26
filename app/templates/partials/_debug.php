<div class="debugger">
	<ul>
		<li>path: <?php var_dump(array_values(array_filter(explode('/', $URL['path'])))); ?></li>
		<li><?php var_dump($testimonials->fetch_assoc()); ?></li>
	</ul>
</div>