<div class="container">

	<?php
		$is_trying_to_validate = false;
		if (isset($validation_token)) {
			// this is a user trying to validate their login from an emailed validation link
			$action = action('UserController@validate', $validation_token);
			$is_trying_to_validate = true;
		} else {
			// this is just a regular login page.
			$action = action('UserController@login');
		}
	?>


	<form class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" method="post" action="<?php echo $action;?>">
		<?php echo Form::token();?>
		<h2>Please sign in <?php if ($is_trying_to_validate):?>again to validate your account.<?php endif; ?></h2>

		<?php if (Session::get("message")):?>
		<p class="help-block">
			<?php echo Session::get("message");?>
		</p>
		<?php endif; ?>
		
		<div class="form-group">
			<label for="email">Email:</label>
			<?php echo Form::text("email", Request::old("email"), ["class"=>"form-control", "placeholder"=>"Email address"]);?>
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input class="form-control" type="password" id="password" name="password" placeholder="Password" value="">
		</div>

		<button type="submit" class="btn btn-success">Sign in</button>

		<br /><br />

		<a href="<?php echo action('UserController@forgot'); ?>">Forgot your password?</a>

	</form>


</div>