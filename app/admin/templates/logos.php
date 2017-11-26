<?php
	$logos = get_table_list('partners', false);
?>
<section class="logo-manager">
	<div class="constrain logo-uploader">
		<div id="message">
		</div>
		<form id="logo-save" action="/_admin/logo_save" method="post" enctype="multipart/form-data">
        <h2>Upload File</h2>
        <input type="hidden" name="token" value="12345">
        <fieldset>
					<label for="photo-title">Title</label>
					<input type="text" id="photo-title" name="title">
				</fieldset>
				<fieldset>
					<label for="photo-url">URL</label>
					<input type="text" id="photo-url" name="url">
				</fieldset>
				<fieldset>
	        <label for="photo-select">File:</label>
  	      <input type="file" name="photo" id="photo-select">
  	    </fieldset>
        <input type="submit" name="submit" value="Upload">
        <p style="font-size: 12px;"><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 1 MB.</p>
    </form>
	</div>
</section>

<section class="logo-list">
	<div class="constrain">
		<table>
			<thead>
				<tr>
					<th>Logo</th>
					<th>Name</th>
					<th>URL</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php while($logo = $logos->fetch_assoc())
					{ ?>
					<tr>
						<td><img src="/public/assets/logos/<?php echo $logo['logo']; ?>" /></td>
						<td><input class="dynamic-form" data-id="<?php echo $logo['id']; ?>" data-field="title" value="<?php echo $logo['title']; ?>" /></td>
						<td><input class="dynamic-form" data-id="<?php echo $logo['id']; ?>" data-field="url" value="<?php echo $logo['url']; ?>"></td>
						<td><input type="checkbox" data-id="<?php echo $logo['id']; ?>" data-field="active" class="dynamic-form" <?php echo $logo['active'] ? "checked" : ""; ?>></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</section>

<script>
	$("#logo-save").on('submit', function(e) {
		e.preventDefault();
		console.log('submitting...')
		$.ajax({
			url: "/_admin/logo_save", // Url to which the request is send
			type: "POST",             // Type of request to be send, called xas method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			beforeSend: function() {
				$('#message').empty()
			},
			success: function(data) { // A function to be called if request succeeds
				$('#message').html(data.message);
				$('#logo-save').trigger('reset');
			},
			error: function(data) {
				var resp = data && data.responseJSON
				$('#message').html(resp.message);
			}
		});
	});

	$('.dynamic-form').on('change', function() {
		var data = {
			'id': $(this).data('id')
		};
		if ($(this).attr('type') === 'checkbox') {
			data[$(this).data('field')] = $(this).is(':checked') ? 1 : 0;
		} else {
			data[$(this).data('field')] = $(this).val();
		}
		data['table'] = "partners";
		data['token'] = 12345;
		$.ajax({
			url: "/_admin/update",
			type: "POST",
			data: data,
			beforeSend: function() { console.log('UPDATING:', data); },
			success: function(data) { console.log('UPDATED:', data); },
			error: function(data) { console.log('ERROR:',data); }
		})
	})

</script>