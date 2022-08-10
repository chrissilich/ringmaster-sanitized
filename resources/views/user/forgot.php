<div class="container">

	<form class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" method="post" action="<?php echo action('UserController@forgot'); ?>">
		<?php echo Form::token();?>
		<h2>Next time pick a password you'll remember, dummy.</h2>

		<?php if (Session::get("message")):?>
		<p class="help-block">
			<?php echo Session::get("message");?>
		</p>
		<?php endif; ?>
		
		<div class="form-group">
			<label for="email">Email:</label>
			<input class="form-control" type="text" id="email" name="email" placeholder="Email address" value="">
		</div>

		<button type="submit" class="btn btn-success">Send me a password reset!</button>

	</form>


</div>