

<div class="container">

	<div class="col-xs-12">

		<h3>
			<?php echo $user->prettyName();?>
		</h3>

		<p>
			Email: <?php echo $user->email;?>
		</p>	

		<p>
			Password: ********
		</p>

		<p>
			<a href="<?php echo action('UserController@edit', $user->id);?>">
				Change something?
			</a>
		</p>
		
	</div>

</div>