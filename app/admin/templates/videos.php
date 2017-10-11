<?php
# Sample urls
# https://vimeo.com/227173715 -> 403
# https://vimeo.com/221817702 -> 200 - iframe restriction
# https://vimeo.com/217057200
# https://vimeo.com/235651192
# https://vimeo.com/61654307
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
					<label for="video-description">Description</label>
					<textarea id="video-description"></textarea>
				</fieldset>
				<fieldset class="inline-labels">
					<label for="video-featured" class="dark-label">Feature In:</label>
					<select id="video-featured">
						<option value="std">Standard (Portfolio Page Only Video)</option>
						<option value="feat">Featured (Homepage &amp; Portfolio Page Only)</option>
						<option value="feat_ex">Feature Exclusive (Homepage Page Only)</option>
						<option value="testim">Testimonial (Testimonial Section Only)</option>
					</select>
				</fieldset>
				<!-- TODO: NEEDS VIDEO TAG SELECTOR -->
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
	<div class="form get-video">
		<ul class="error-messages">
		</ul>
		<input type="text" placeholder="Enter video URL to add video" value="https://vimeo.com/217057200"/>
		<button id="query-video" class="button dark-opaque to-gold-bg">Get Video</button>
	</div>
</section>

<script>
	var videoData = {};
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
					
					var editor = ClassicEditor.create(document.querySelector('#video-description'), {
						toolbar: [ 'bold', 'italic', 'link', 'bulletedList', 'numberedList' ]
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
		$('.get-video').removeClass('hidden').find('input').val(null);

		$('.add-video').addClass('hidden');
	})

	$('#confirm-save').on('click', function() {
		var title = $('#video-title').val(),
				submitData = {
					'slug': slugify(title),
					'title': title,
					'description': $('#video-description').val(),
					'url': videoData.url,
					'iframe': videoData.iframe, 
					'thumbnail': videoData.thumbnail,
					'provider': videoData.provider,
					'feature_tag': $('#video-featured').val(),
					'video_id': videoData.video_id,
					'token': generateToken()
				};

				$.ajax({
					type: 'POST',
					url: '/_admin/video_save',
					data: submitData,
					dataType: 'json',
					success: function(resp) {
						console.log(resp);
					},
					error: function(resp) {
						console.log(resp);
					}
				})


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