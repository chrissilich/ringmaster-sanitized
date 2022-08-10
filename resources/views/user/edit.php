<div class="container">

	<?php echo Form::open(['action' => ['UserController@update', $user->id], 'method' => 'put', 'class' => "col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6"]);?>

		<?php echo Form::token();?>
	
		<h2>Edit User: <?php echo $user->prettyName();?></h2>

		<div class="form-group">
			<label for="name">Name</label>
			<?php echo Form::text('name', $user->name, ["class" => "form-control", "placeholder" => "Joe Student"]);?>
			<?php if($errors->has('name')):?>
				<p class="help-block"><?php echo $errors->first('name');?></p>
			<?php endif;?>
		</div>



		<div class="form-group">
			<label for="oldpassword">Old Password</label>
			<p>
				If you don't want to change your password, leave all these password fields blank.
			</p>
			<input class="form-control" type="password" id="oldpassword" name="oldpassword" placeholder="whatever your old password was">
			<?php if($errors->has('oldpassword')):?>
				<p class="help-block"><?php echo $errors->first('oldpassword');?></p>
			<?php endif;?>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input class="form-control" type="password" id="password" name="password" placeholder="not 1234">
			<?php if($errors->has('password')):?>
				<p class="help-block"><?php echo $errors->first('password');?></p>
			<?php endif;?>
		</div>

		<div class="form-group">
			<label for="password2">Password Again</label>
			<input class="form-control" type="password" id="password2" name="password2" placeholder="not 1234">
			<?php if($errors->has('password2')):?>
				<p class="help-block"><?php echo $errors->first('password2');?></p>
			<?php endif;?>
		</div>

		


		<button class="col-xs-12 btn btn-success" type="submit">Save Changes</button>

	</form>

</div>