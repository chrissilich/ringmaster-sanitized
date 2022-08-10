<div class="container">

	<form class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" method="POST" action="<?php echo action('UserController@store');?>" novalidate>
		<?php echo Form::token();?>
	
		<h2>Register</h2>

		<div class="form-group">
			<label for="email">Email Address</label>
			<input class="form-control" type="text" id="email" name="email" placeholder="you@domain.com" value="<?php echo Request::old('email');?>">
			<?php if($errors->has('email')):?>
				<p class="help-block"><?php echo $errors->first('email');?></p>
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

		


		<button class="col-xs-12 btn btn-success" type="submit">Register</button>

	</form>

</div>