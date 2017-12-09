<?php
$categories = get_categories();
	$video = get_video_by_id($_GET['id']);
?>
<section>
	<div class="add-video">
		<div class="constrain">
			<div class="video-player"><?php echo $video['iframe']; ?></div>
			<div class="form">
				<fieldset>
					<label for="video-title">Title</label>
					<input type="text" id="video-title" value="<?php echo $video['title']; ?>">
				</fieldset>
				<fieldset>
					<label for="video-title">Client</label>
					<input type="text" id="video-client" value="<?php echo $video['client']; ?>">
				</fieldset>
				<fieldset>
					<label for="video-description">Description</label>
					<textarea id="video-description"><?php echo $video['description']; ?></textarea>
				</fieldset>
				<fieldset class="inline-labels">
					<label for="video-featured" class="dark-label">Feature In:</label>
					<select id="video-featured" data-value="<?php echo $video['feature_tag']; ?>">
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
					<img src="<?php echo $video['thumbnail']; ?>">
				</div>
				<div class="text-right">
					<button class="button light-opaque to-gold-bg" id="cancel-save">Cancel</button>
					<button class="button dark-opaque to-gold-bg" id="confirm-save">Update</button>
					<a href="/video/<?php echo $video['slug']; ?>" class="button dark-opaque to-gold-bg text-center" target="_blank">View page</a>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	container = {}
	$(document).ready(function(){
		ClassicEditor.create(document.querySelector('#video-description'), {
			toolbar: [ 'bold', 'italic', 'link', 'bulletedList', 'numberedList' ]
		}).then(function (editor) {
			container.editor = editor;
		})

		$('#video-featured').find('[value=' + $('#video-featured').data('value') +']').attr('selected',true);

		var current_tags = "<?php echo $video['tags']; ?>".split(',');
		$.each(current_tags, function(ct) {
			$('[name="video_types[]"][value="'+ct+'"]').attr('checked', true);
		});
	});

	$('#cancel-save').on('click', function() {
		$('.get-video').removeClass('hidden').find('input').val(null);

		$('.add-video').addClass('hidden');
	})

	$('#confirm-save').on('click', function() {
		var title = $('#video-title').val(),
				video_types = $.map( $('.video-tags input[name="video_types[]"]'), function(el) {
						if ($(el).is(':checked')) {
							return parseInt($(el).val());
						}
					}),
				videoData = <?php echo json_encode($video); ?>,
				submitData = {
					'id': videoData.id,
					'client': $('#video-client').val(),
					'slug': videoData.slug,
					'title': title,
					'description': container.editor.getData(),
					'url': videoData.url,
					'iframe': videoData.iframe, 
					'thumbnail': videoData.thumbnail,
					'provider': videoData.provider,
					'feature_tag': $('#video-featured').val(),
					'video_id': videoData.video_id + Date.now(),
					'tags': video_types.join(),
					'token': generateToken()
				};
				$.ajax({
					type: 'POST',
					url: '/_admin/video_update',
					data: submitData,
					dataType: 'json',
					success: function(resp) {
						alert('Successfully updated video.');
						console.log(resp);
					},
					error: function(resp) {
						alert('Error Updating Video');
						console.log(resp.responseJSON);
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