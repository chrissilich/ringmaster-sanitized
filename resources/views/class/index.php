<div class="container">

	<div class="col-xs-12 col-sm-12 push-down">
		

		<?php 
		$classesImIn = array();
		$classesIRun = array();
		foreach (Auth::user()->classrooms as $c) {
			//echo $c;
			if ($c->is_admin()) {
				array_push($classesIRun, $c);
			} else {
				array_push($classesImIn, $c);
			}
		} ?>



		<h1>My Classes</h1>

		<table class="table table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>My Role</th>
				</tr>
			</thead>
		<?php foreach (Auth::user()->classrooms as $c): ?>
			<tr class="<?php if (Carbon::parse($c->start_date)->gt(Carbon::now())): ?>early<?php endif; ?> <?php if (Carbon::parse($c->end_date)->lt(Carbon::now())): ?>past<?php endif; ?>">
				<td>
					<h4>
						<a href="<?php echo action('ClassroomController@show', array($c->id));?>">
							<?php echo $c->name;?> 
						</a>
						
					</h4>
					<?php if (count($c->creators)): ?>
						<h5>
							<?php echo $c->creators[0]->prettyName();?>
						</h5>
					<?php endif; ?>
					<p>
						<?php echo $c->description; ?>
					</p>
					<?php if (Carbon::parse($c->start_date)->gt(Carbon::now())): ?><p><em class="text-muted small">Class hasn't started yet</em></p><?php endif; ?>
					<?php if (Carbon::parse($c->end_date)->lt(Carbon::now())): ?><p><em class="text-muted small">Class has finished</em></p><?php endif; ?>
				</td>
				<td>
					<?php echo Carbon::parse($c->start_date)->toFormattedDateString();?>
				</td>
				<td>
					<?php echo Carbon::parse($c->end_date)->toFormattedDateString();?>
				</td>
				<td>
					<?php echo $c->pivot->role;?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		


	</div>

</div>