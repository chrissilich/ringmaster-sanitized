
<form class="navbar-form navbar-right" role="form" method="post" action="<?php echo action('UserController@login'); ?>" >
	<?php echo Form::token();?>
	<div class="form-group">
		<input type="text" id="email" name="email" placeholder="Email" class="form-control">
	</div>

	<div class="form-group">
		<input type="password" id="password" name="password" placeholder="Password" class="form-control">
	</div>

	<button type="submit" class="btn btn-success">Sign in</button> &nbsp;

	<a class="small" href="<?php echo action('UserController@forgot'); ?>">Forgot? </a>
</form>