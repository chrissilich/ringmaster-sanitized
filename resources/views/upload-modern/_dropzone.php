<?php $rand = rand(100000, 1000000); ?>
<div class="chunk-uploader dropzone">
	<div id="uploader-<?php echo $rand;?>" class="drop-zone">
		<div class="message">
			Click/tap here<span class="hidden-xs">, or drag and drop files here</span> to upload.
		</div>
		<ul></ul>
	</div>
	<div class="drop-zone-previews"></div>
</div>

<input name="upload_ids" id="upload-ids-<?php echo $rand;?>">

<script>
Dropzone.autoDiscover = false;

(function() {

	var fileIDs = [];
	var fileIDsElement = document.querySelector('#upload-ids-<?php echo $rand;?>');
	 

	new Dropzone("#uploader-<?php echo $rand;?>", {
		url: "<?php echo action('UploadModernController@store');?>",
		method: 'post',
		clickable: true,
		// addRemoveLinks: true,
		withCredentials: true, //default: false
		timeout: 10000, // default: 30000
		parallelUploads: 3, // 2
		uploadMultiple: false,
		chunking: true, // false
		forceChunking: false,
		chunkSize: 3000000, // 2000000 (2mb)
		parallelChunkUploads: false, // false
		maxFilesize: 200, // default: 256
		maxFiles: 20,
		previewsContainer: '.drop-zone-previews',
		headers: {
			'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
		},
		createImageThumbnails: false, // true
	
	}).on('totaluploadprogress', function(a,b,c) {
		console.log('totaluploadprogress', a,b,c)
		$('#uploader-<?php echo $rand;?> div.message').html('Uploading... ~'+Math.round(b/1000000)+'mb sent')
		
	}).on('success', function(e, a,b,c) {
		console.log('upload success')
		var res = JSON.parse(e.xhr.response)
		console.log(res)
		fileIDs.push(res.data.id)
		fileIDsElement.value = fileIDs

		$('#uploader-<?php echo $rand;?>').addClass('drop-zone-full')

		$('#uploader-<?php echo $rand;?> ul').append('<li>'+res.data.filename+'</li>')

		$('#uploader-<?php echo $rand;?> div.message').html('Click/tap here<span class="hidden-xs">, or drag and drop files here</span> to upload.')

	}).on('error', function(errorMessage) {
		console.warn('dropzone errorMessage', errorMessage)

		var msg = $('<div class="alert alert-danger" role="alert"><strong>Something went wrong with your upload. </strong>Make sure your files are under the maximum file size, and you\'re not uploading more than 20 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		msg.insertAfter( $('#uploader-<?php echo $rand;?>') )
	})

})()
</script>