<div class="container">
	
	<?php echo Form::open(array(
		"class" => "col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6",
		"url" => action('AssignmentSubmissionController@store', [$assignment->classroom->id, $assignment->id]),
		"files" => true
	));?>

		<h2>
			Submit Your Assignment<br />
			<small>
				Assignment: <em><?php echo $assignment->name;?></em>; for class: <em><?php echo $assignment->classroom->name;?></em>
			</small>				
		</h2>

		<input type="hidden" id="assignment_id" name="assignment_id" value="<?php echo $assignment->id;?>">


		<div class="form-group">
			<label for="content">Content</label>
			<textarea class="form-control" type="text" id="content" name="content" placeholder="Assignment Content" value="<?php echo Request::old('content');?>" rows="5"></textarea>
			<?php if($errors->has('content')):?>
				<p class="help-block"><?php echo $errors->first('content');?></p>
			<?php endif;?>
		</div>


		<div class="form-group">
			<label for="content">Upload a File (20mb max, zip multiple files together)</label>
			<?php echo Form::file('file');?>
			<?php if($errors->has('file')):?>
				<p class="help-block"><?php echo $errors->first('file');?></p>
			<?php endif;?>
		</div>

		




		<button class="col-xs-12 btn btn-success" type="submit">Submit Assignment</button>

	</form>
</div>