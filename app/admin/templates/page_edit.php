<?php
	$page = get_page_type_ids($_GET['id']);
	$contents = get_page_content($_GET['id']);
	$translations = get_page_translations($_GET['id']);
?>

<section>
	<div class="constrain content-list">
		<div id="show-current-strings" class="styled-form">
			<div class="text-left">
				<h3 style="margin:0;">Manage existing text</h3>
			</div>

			<table>
				<thead>
					<tr>
						<th>Key</th>
						<th>Text</th>
						<th>Update</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($translations as $key => $translation) { ?>
						<tr>
							<td><?php echo $key; ?></td>
							<td>
								<textarea data-target="<?php echo $key; ?>"><?php echo $translation; ?></textarea>
							</td>
							<td><button class="update-copy" data-target="<?php echo $key; ?>">Save</button>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>

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

	$('.update-copy').on('click', function() {
		var target = $(this).data('target'),
				data = {
					'id': null,
					'mapping_key': target,
					'mapping_string': $('textarea[data-target="'+target+'"]').val()
				};
		data['table'] = "contents";
		data['token'] = generateToken();
		$.ajax({
			url: "/_admin/update",
			type: "POST",
			data: data,
			beforeSend: function() { console.log('UPDATING:', data); },
			success: function(data) { console.log('UPDATED:', data); },
			error: function(data) { console.log('ERROR:',data); }
		})
	})

	function generateToken() {
		return 12345;
	}
</script>