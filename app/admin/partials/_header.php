<!DOCTYPE html>
	<head>
		<title>Admin | Randy Witt Productions</title>
		<link href="/public/styles/application.css" rel="stylesheet" type="text/css" />
		<link href="/public/styles/admin.css" rel="stylesheet" type="text/css" />
		<script src="/public/scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="/public/scripts/ckeditor.js" type="text/javascript"></script>
	</head>
	<body class="admin">
		<header>
			<a class="logo" href="/" title="Randy Witt Productions"></a>
			<nav>
				<?php foreach ($admin_nav as $nav) { ?>
						<a class="light" href="<?php echo $nav['url']; ?>"><?php echo $nav['title']; ?></a>
					<?php } ?> 
			</nav>
		</header>

		<section>
			<div class="full-constrain">
				<h1><?php echo page_key_to_title($data['page_key']); ?></h1>
			</div>
		</section>