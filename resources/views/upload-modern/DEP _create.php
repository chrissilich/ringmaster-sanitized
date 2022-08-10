

<div class="chunk-uploader" data-limit="1" data-action="<?php echo action('UploadModernController@store');?>">
	
	<div class="drop-zone">
		<span class="instructions">Drop files here to upload.</span>
		<span class="percent"></span>
		<ul class="uploads"></ul>
	</div>

	<div class="clearfix"></div>
	<div class="text-right">
		
		<button type="button" class="browse-button btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Browse...</button>
		<button type="button" class="clear-uploads btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove all files</button>
		<!-- <button type="button" class="start-upload btn btn-success">Upload</button> -->
		<p class="info info-first">
			100mb max per file.
		</p>
		<p class="info">
			Formats supported: images, psd, ai, pdf.
		</p>
		<p class="info">
			Zip everything else.
		</p>
	</div>
	<?php echo Form::hidden('upload_ids', '', ["class" => "upload_ids"]);?>
</div>






<script type="text/javascript">initChunkUploader();</script>


