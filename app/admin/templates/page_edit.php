<?php
	$page = get_page_type_ids($_GET['id']);
	$contents = get_page_content($_GET['id']);
?>

<section>
	<div class="constrain content-list">
		<h2>Managing <?php echo $page['title']; ?></h2>
				

		<hr />

		<div id="add-new-string" class="add-new-string styled-form hidden">
			<div class="text-left">
				<h3 style="margin:0;">Add a string</h3>
				<p style="margin: 0;">This is an advanced feature. A code update is necessary to display new text on the site.</p>
			</div>
			<div>
				<input id="mapping-key" type="text" value="" placeholder="Mapping key" /><br>
				<textarea id="mapping-string" placeholder="Text to display"></textarea><br>
				<textarea id="mapping-definition" placeholder="Where does this string display?"></textarea>
			</div>
			<button id="add-text" class="button dark-opaque to-gold-bg">Add Text</button>
		</div>
	</div>
</section>

<script>
	$(document).ready(function() {
		if (location.hash == '#developer') {
			$('#add-new-string').show();
		}
	})

	$('#add-text').on('click', function() {
		var key = $('#mapping-key').val(),
				value = $('#mapping-string').val(),
				definition = $('#mapping-definition').val(),
				submitData = {
					'page_id': <?php echo $_GET['id']; ?>,
					'mapping_key': key,
					'mapping_string': value,
					'definition': definition,
					'token': generateToken()
				};
		if (key.length > 0 && value.length > 0) {
			$.ajax({
				type: 'POST',
				url: '/_admin/save_string',
				data: submitData,
				dataType: 'json',
				success: function(resp) {
					console.log(resp);
					alert('Successfully created string.');
				},
				error: function(resp) {
					console.log(resp.responseJSON);
					alert("Error creating string: " + resp.responseJSON.error);
				}
			});
		}
	});

	function generateToken() {
		return 12345;
	}
</script>