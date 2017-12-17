<?php
	# Sample urls
	# https://vimeo.com/227173715 -> 403
	# https://vimeo.com/221817702 -> 200 - iframe restriction
	# https://vimeo.com/217057200
	# https://vimeo.com/235651192
	# https://vimeo.com/61654307
	$categories = get_categories();
	$videos = get_videos('all');
?>
<section>
	<div class="add-video hidden">
		<div class="constrain">
			<div class="video-player"></div>
			<div class="form">
				<fieldset>
					<label for="video-title">Title</label>
					<input type="text" id="video-title">
				</fieldset>
				<fieldset>
					<label for="video-client">Client</label>
					<input type="text" id="video-client">
				</fieldset>
				<fieldset>
					<label for="video-description">Description</label>
					<textarea id="video-description"></textarea>
				</fieldset>
				<fieldset class="inline-labels">
					<label for="video-featured" class="dark-label">Feature In:</label>
					<select id="video-featured">
						<option value="hide">None (Unpublished)</option>
						<option value="std">Standard (Portfolio Page Only Video)</option>
						<option value="feat">Featured (Homepage &amp; Portfolio Page Only)</option>
						<option value="feat_ex">Feature Exclusive (Homepage Page Only)</option>
						<option value="testim">Testimonial (Testimonial Section Only)</option>
					</select>
				</fieldset>
				<!-- TODO: NEEDS VIDEO TAG SELECTOR -->
				<div class="video-tags">
						<div class="dark-label">Video Types</div>
						<?php while($cat = $categories->fetch_assoc())
							{ ?>
								<fieldset class="inline-labels inline-fieldsets">
									<input id="video_type_<?php echo $cat['id']; ?>" type="checkbox" name="video_types[]" value="<?php echo $cat['id']; ?>" />
									<label for="video_type_<?php echo $cat['id']; ?>" class="dark-label"><?php echo $cat['title']; ?></label>
								</fieldset>
						<?php } ?>

				</div>
				<div class="thumbnail-preview">
					<label>Thumbnail Image Preview</label>
					<img src="">
				</div>
				<div class="text-right">
					<button class="button light-opaque to-gold-bg" id="cancel-save">Cancel</button>
					<button class="button dark-opaque to-gold-bg" id="confirm-save">Save</button>
				</div>
			</div>
		</div>
	</div>
	<div class="form styled-form">
		<ul class="error-messages">
		</ul>
		<input type="text" placeholder="Enter video URL to add video (ex: https://vimeo.com/217057200)"/>
		<button id="query-video" class="button dark-opaque to-gold-bg">Get Video</button>
	</div>
</section>

<section>
	<div class="constrain content-list">
		<table>
			<thead>
				<tr>
					<th>Title</th>
					<th>View Page</th>
					<th>View Source</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php while($video = $videos->fetch_assoc())
					{ ?>
					<tr>
						<td><?php echo $video['title']; ?></td>
						<td><a href="/video/<?php echo $video['slug']; ?>" target="_blank">Visit Page</a></td>
						<td><a href="<?php echo $video['url']; ?>" target="_blank">Visit Source</a></td>
						<td><a href="/_admin/videos_edit?id=<?php echo $video['id']; ?>">Edit</a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</section>

<script>
	var videoData = {}, container = {};
	$('#query-video').on('click', function() {
		var url = $('.get-video input').val();
		if (url && url != '') {
			var data = {
				"token": generateToken(),
				"url": url
			}
			$.ajax({
				type: 'POST',
				url: '/_admin/video_import',
				data: data,
				dataType: 'json',
				beforeSend: function() {
					$('#query-video').attr('disabled',true);
					$('.error-messages').empty();
				},
				success: function(resp) {
					var video = resp.data,
							$addVideo = $('.add-video'),
							descriptions = video.description.split("\n"),
							description = [];

					videoData = resp.data;

					// TODO delete me...
					$('#query-video').attr('disabled',false);

					$addVideo.find('.video-player').html(video.iframe);
					$addVideo.find('#video-title').val(video.title);
					
					ClassicEditor.create(document.querySelector('#video-description'), {
						toolbar: [ 'bold', 'italic', 'link', 'bulletedList', 'numberedList' ]
					}).then(function (editor) {
						container.editor = editor
					})

					$.each(descriptions, function(index, desc) {
						if (desc.length > 1) {
							description.push( '<p>' + desc + '</p>' );
						}
					});
					description.join('')
					$addVideo.find('#video-description').val(description.join(''));

					$addVideo.find('.thumbnail-preview img').attr('src',video.thumbnail);
					$('.add-video').removeClass('hidden');
					
					$('.get-video').addClass('hidden');
				},
				error: function(resp) {
					$('#query-video').attr('disabled',false);
					var message = $('<li/>', {
						text: resp.responseJSON.message
					})
					$('.error-messages').html(message);
				}
			});
		}
	});

	$('#cancel-save').on('click', function() {
		location.href = location.href;
	})

	$('#confirm-save').on('click', function() {
		var title = $('#video-title').val(),
				video_types = $.map( $('.video-tags input[name="video_types[]"]'), function(el) {
						if ($(el).is(':checked')) {
							return parseInt($(el).val());
						}
					}),
				submitData = {
					'slug': slugify(title),
					'title': title,
					'description': container.editor.getData(),
					'url': videoData.url,
					'iframe': videoData.iframe, 
					'thumbnail': videoData.thumbnail,
					'provider': videoData.provider,
					'feature_tag': $('#video-featured').val(),
					'video_id': videoData.video_id,
					'tags': video_types.join(),
					'client': videoData.client,
					'token': generateToken()
				};

		$.ajax({
			type: 'POST',
			url: '/_admin/video_save',
			data: submitData,
			dataType: 'json',
			success: function(resp) {
				console.log(resp);
				alert('Successfully created video.');
			},
			error: function(resp) {
				console.log(resp.responseJSON);
				alert("Error creating video: " + resp.responseJSON.error);
			}
		});
	});

	function generateToken() {
		return 12345;
	}

	function slugify(text) {
	  return text.toString().toLowerCase()
	    .replace(/\s+/g, '-')           // Replace spaces with -
	    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
	    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
	    .replace(/^-+/, '')             // Trim - from start of text
	    .replace(/-+$/, '');            // Trim - from end of text
	}

</script>