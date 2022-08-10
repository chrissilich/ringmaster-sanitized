<div class="container">

	<form class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" method="post" action="<?php echo action('UserController@forgotValidate', $forgot_token); ?>">
		<?php echo Form::token();?>
		<h2>Reset your password!</h2>

		<?php if (Session::get("message")):?>
		<p class="help-block">
			<?php echo Session::get("message");?>
		</p>
		<?php endif; ?>

		<input type="hidden" id="forgot_token" name="forgot_token" value="<?php echo $forgot_token;?>">
		
		<div class="form-group">
			<label for="email">Email:</label>
			<input class="form-control" type="text" id="email" name="email" placeholder="Email address" value="">
			<?php if($errors->has('email')):?>
				<p class="help-block"><?php echo $errors->first('email');?></p>
			<?php endif;?>
		</div>

		<div class="form-group">
			<label for="password">New Password:</label>
			<input class="form-control" type="password" id="password" name="password" placeholder="Password" value="">
			<?php if($errors->has('password')):?>
				<p class="help-block"><?php echo $errors->first('password');?></p>
			<?php endif;?>
		</div>

		<div class="form-group">
			<label for="password">New Password Again:</label>
			<input class="form-control" type="password" id="password2" name="password2" placeholder="Password" value="">
		</div>

		<button type="submit" class="btn btn-success">I'll remember it this time!</button>

	</form>


</div>