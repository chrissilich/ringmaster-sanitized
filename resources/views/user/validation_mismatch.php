
<div class="container">

	<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">

		<h2>Validation Mismatch</h2>

		<p>
			You tried to validate this email address (<?php echo Auth::user()->email;?>), but the validation code didn't match.
		</p>
		<p>
			If you can't find one, we can send you a new email.
		</p>
		<a class="btn btn-warning" href="<?php echo action('UserController@requestNewValidationToken');?>">Resend Validation Email</a>


	</div>

</div>