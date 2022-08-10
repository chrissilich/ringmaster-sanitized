<div class="container">

	<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">

		<h1>Bad Password Reset Link</h1>
		<p>You're attempting to reset your password, but this reset request has expired (or never existed). </p>

		<p>Go back to your email and make sure you find the <em>most recent</em> email titled "Ringmaster Forgot Password" and use the link in that one.</p>

		<p>If you can't find that one (even in your spam folder), you can <a href="<?php echo action('UserController@forgot');?>">go through the process</a> again.</p>
	</div>

</div>