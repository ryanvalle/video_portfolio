<!DOCTYPE html>
	<head>
		<title>Admin | Randy Witt Productions</title>
		<link href="/public/styles/application.css" rel="stylesheet" type="text/css" />
		<link href="/public/styles/admin.css" rel="stylesheet" type="text/css" />
		<script src="/public/scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="/public/scripts/ckeditor.js" type="text/javascript"></script>
		<script>
			$(function() {
				$('#logout').on('click', function(e) {
					e.preventDefault();
					var that = this;
					$.ajax({
						url: '/_admin/revoke',
						method: "POST",
						success: function(resp) {
							now = new Date(0);
							document.cookie = "rwp_admin_session= ;expires=" + now + "; path=/";
							location.href = $(that).attr('href');
						},
						error: function(resp) {
							now = new Date(0);
							document.cookie = "rwp_admin_session= ;expires=" + now + "; path=/";
							location.href = $(that).attr('href');
						}
					})
				});
			})
		</script>
	</head>
	<body class="admin">
		<header>
			<a class="logo" href="/" title="Randy Witt Productions"></a>
			<nav>
				<?php if (is_logged_in()) { ?>
				<?php foreach ($admin_nav as $nav) { 
					if ($nav['active_nav']) { ?>
						<a class="light" href="<?php echo $nav['url']; ?>"><?php echo $nav['title']; ?></a>
					<?php } }?> 
					<a class="light" href="/_admin" id="logout">Log Out</a>
					<?php } ?>
			</nav>
		</header>

		<section>
			<div class="full-constrain">
				<h1><?php echo page_key_to_title($data['page_key']); ?></h1>
			</div>
		</section>