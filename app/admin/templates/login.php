<section>
	<div class="constrain">
		<div class="styled-form">
			<form id="login-form">
				<input type="text" id="username" autocomplete="username" placeholder="Username" />
				<input type="password" id="password" autocomplete="current-password" placeholder="Password" />
				<button id="login" class="button dark-opaque to-gold-bg full-width">Login</button>
			</form>
		</div>
	</div>
</section>

<script>
	$('#login-form').on('submit',function(e) {
		e.preventDefault();
		$.ajax({
			url: '/_admin/authenticate',
			method: "POST",
			data: {
				"user": $('#username').val(),
				"password": $('#password').val()
			},
			success: function(resp) {
				var token = resp && resp.token;
				if (token) {
					document.cookie = "rwp_admin_session="+token+';path=/';
					location.href = "/_admin/home";
				}
			},
			error: function(resp) {
				alert('Incorrect username or password');
			}
		})
	})
</script>