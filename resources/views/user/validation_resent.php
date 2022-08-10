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

		<h2>Validation Email Resent</h2>

		<p>
			Okay, we've resent you the Validation Email. Don't forget to check your spam folder. It might take a few minutes.
		</p>
		<p>
			Once you validate your email, this page should go away on it's own. If not, just refresh it.
		</p>



	</div>

</div>