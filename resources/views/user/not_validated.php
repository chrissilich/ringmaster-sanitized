<script>
function checkValidation() {
	console.log("checkValidation");
	$.getJSON('<?php echo action("UserController@validatedToken");?>')
		.done(function(r) {
			if (parseInt(r.validated)) {
				console.log("checkValidation true");
				window.location.href = '<?php echo action("HomeController@index");?>';
			} else {
				console.log("checkValidation false");
				setTimeout(checkValidation, 2000);
			}
		})

}
checkValidation();
</script>

<div class="container">

	<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">

		<h2>Unvalidated Login</h2>

		<p>
			You can't log in until you've validated your email address.
		</p>
		<p>
			<a class="btn btn-success" href="<?php echo action('UserController@requestNewValidationToken');?>">Resend Validation Email</a>
		</p>



	</div>

</div>