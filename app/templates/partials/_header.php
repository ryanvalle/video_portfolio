<!DOCTYPE html>
	<head>
		<title><?php echo get_page_title($data); ?></title>
		<link href="/public/styles/application.css" rel="stylesheet" type="text/css" />
		<script src="/public/scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<header>
			<div class="constrain">
				<a class="logo" href="/" title="Randy Witt Productions"></a>
				<nav>
					<?php foreach ($navigation as $nav) { ?>
						<a class="light" href="<?php echo $nav['url']; ?>"><?php translate('global_nav_' . $nav['title']); ?></a>
					<?php } ?> 
				</nav>
			</div>
		</header>
		<?php # TODO: MAKE SIZE CLASS CONFIGURABLE ?>
		<section class="hero <?php echo $header_type; ?>">
			<?php 
				if ($data['template']) {
					include('templates/heroes/' . $data['template'] . '.php');
				} else {
					include('templates/heroes/404.php');
				}
			?>	
		</section>
