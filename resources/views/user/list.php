

<div class="container">

	<div class="col-xs-12">

		<h1>Users</h1>

		<button class="btn btn-default" type="submit">Button</button>

		<table id="user_list" class="table table-striped table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
				</tr>
			</thead>
			<?php foreach ($users as $u): ?>
				<?php if (Auth::user()->god()): // prevent school level users from seeing Ringmaster level users ?>
					<tr>
						<td><?php echo $u->id;?></td>
						<td>
							<a href="<?php echo action("UserController@show", $u->id);?>">
								<?php echo $u->name;?>
								<?php if (!$u->name):?>
									<em>No name</em>
								<?php endif; ?>
							</a>
						</td>
						<td><?php echo $u->email;?></td>
						
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		</table>
	</div>

</div>