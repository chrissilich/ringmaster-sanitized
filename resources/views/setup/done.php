<div class="container">

	<form class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6" method="POST" action="<?php echo action('SetupController@doName');?>" novalidate>
		<?php echo Form::token();?>

		<h2>
			All done.
		</h2>

		<p>
			You're all set. Go learn something.
		</p>


		
		<br />
		<p>
			<a href="<?php echo action('HomeController@index');?>" class="col-xs-12 col-sm-8 col-sm-offset-2 btn btn-success" type="submit">e = MC<sup>2</sup></a><br /><br />
		</p>
	</form>

</div>