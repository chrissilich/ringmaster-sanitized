<div class="container">

	<form id="setup_classes" class="ajax-form col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" method="POST" action="<?php echo action('ClassroomController@storejoin');?>" novalidate>
		<?php echo Form::token();?>
		
		<h2>
			<small>Step 2 of 2</small><br />
			Let's find your class.
		</h2>

		

		<div class="form-group">
			<p>
				If you already know the "Join Code" for the class you want to join, enter it here. 
			</p>
			<input class="form-control" type="text" id="join_code" name="join_code" placeholder="two words" value="<?php echo Request::old('join_code');?>">
			
			<?php if ($errors->has('join_code')):?>
				<p class="help-block"><?php echo $errors->first('join_code');?></p>
			<?php endif;?>
		</div>

		<input type="hidden" name="success_redirect" value="<?php echo action('SetupController@done');?>">

		<p>
			If you're a student and you don't have a join code, bug your teacher for one.<br />
			If you're a teacher and you don't
			want to join any classes, just skip this step.
		</p>


		
		<br />
		<p>
			<button class="col-xs-12 col-sm-8 col-sm-offset-2 btn btn-success" type="submit">That's the weirdest thing I've ever typed.</button><br /><br />
			<a href="<?php echo action('SetupController@done');?>" class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4 btn btn-danger">Skip this step...</a>
		</p>
	</form>

</div>