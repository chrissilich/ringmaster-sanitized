<?php
	if (!isset($classes)) $classes = "";
	if (!isset($id)) $id = "";
	if (!isset($named)) $named = true;
	if (!isset($replace)) $replace = false;
?>
<?php echo Form::open(array(
	"id" => 	$id,
	"class" => 	$classes,
	"url" => 	action('UploadController@store'),
	"files" => 	true
));?>


	<input type="hidden" id="belongs_to_type" name="belongs_to_type" value="<?php echo $belongs_to_type;?>">
	<input type="hidden" id="belongs_to_id" name="belongs_to_id" value="<?php echo $belongs_to_id;?>">
	<input type="hidden" id="upload_kind" name="upload_kind" value="<?php echo $upload_kind;?>">
	<input type="hidden" id="upload_replace" name="upload_replace" value="<?php echo $replace;?>">
	
	<br />

	<div class="form-group">
	
		<?php if ($named): ?>
			<div class="form-group">
				<label for="name">Upload name</label>
				<input class="form-control" type="text" id="name" name="name" placeholder="Upload name" value="<?php echo Request::old('name');?>">
				<?php if($errors->has('name')):?>
					<p class="help-block"><?php echo $errors->first('name');?></p>
				<?php endif;?>
			</div>
		<?php endif; ?>
		
		<label for="file">File <small>(ZIP multiple files)</small></label>
		
		<?php echo Form::file('file', array('id'=>'','class'=>''));?>

		<?php if(Session::get("error")):?>
			<p class="help-block"><?php echo Session::get("error");?></p>
		<?php endif;?>
	</div>


	<button class="col-xs-12 btn btn-success" type="submit">Upload File</button>

<?php echo Form::close(); ?>

<?php if(Session::get("message")):?>
	<p class="help-block"><?php echo Session::get("message");?></p>
<?php endif;?>


<br />