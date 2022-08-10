<div class="container">

	<form class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" method="POST" action="<?php echo action('SetupController@doName');?>" novalidate>
		<?php echo Form::token();?>

		<h2>
			<small>Step 1 of 2</small><br />
			What should we call you?
		</h2>

		<div class="form-group">
			<input class="form-control" type="text" id="fname" name="fname" placeholder="First" value="<?php echo Request::old('fname');?>">
			<?php if($errors->has('fname')):?>
				<p class="help-block"><?php echo $errors->first('fname');?></p>
			<?php endif;?>
		</div>
		<div class="form-group">
			<input class="form-control" type="text" id="lname" name="lname" placeholder="Last" value="<?php echo Request::old('lname');?>">
			<?php if($errors->has('lname')):?>
				<p class="help-block"><?php echo $errors->first('lname');?></p>
			<?php endif;?>
		</div>



		
		<br />
		<p>
			<button class="col-xs-12 col-sm-8 col-sm-offset-2 btn btn-success" type="submit">That's my name, don't wear it out!</button><br /><br />
			<a href="<?php echo action('SetupController@classes');?>" class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4 btn btn-danger">Skip this step...</a>
		</p>
	</form>


</div>