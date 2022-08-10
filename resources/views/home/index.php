<div class="container">

	<div class="col-xs-12 col-sm-8 push-down">
		
		<div class="alert alert-warning" role="alert">
			<strong>Ringmaster is going away</strong><br>
			Ringmaster will stay online for a while so you can see your old assignments, but new classes should be on Google Classroom.
		</div>

		<h4>Upcoming Assignments</h4>

		<table class="table table-striped table-hover">
		<?php foreach ($assignments as $a): ?>
			<tr class="table-row">
				<td class="table-cell">
					<h5>
						<a href="<?php echo action("ClassroomController@show", $a->classroom->id);?>?show=assignments">
							<?php echo $a->name;?> &nbsp;
							<em class="text-muted"><?php echo $a->classroom->name;?></em>
						</a>

						<span style="float: right; text-align: right">
							<em class="text-muted">due</em>
							<?php echo Carbon::parse($a->due)->format('D, j M');?>							
							<em class="text-muted">at</em>
							<?php echo Carbon::parse($a->due)->format('h:ia');?>							
						</span>

					</h5>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if (!count($assignments)): ?>
			<tr>
				<td class="text-muted" style="background-color: white">
					<em>No assignments upcoming.</em>
				</td>
			</tr>
		<?php endif; ?>
		</table>



		<br />
		<h4>Upcoming Events</h4>

		<table class="table table-striped table-hover">
		<?php foreach ($events as $e): ?>
			<tr class="table-row">
				<td class="table-cell">
					<h5>
						<?php if ($e->belongs_to_type == "classroom"): ?>
							<a href="<?php echo action("ClassroomController@show", $e->classroom->id);?>?show=discussion">
								<?php echo $e->name;?>
							</a>
							&nbsp;
							<em class="text-muted"><?php echo $e->classroom->name;?></em>
						<?php endif; ?>

						<span style="float: right; text-align: right">
							<?php
							$sameDay = false; 
							if (Carbon::parse($e->start)->format('D, j M') != Carbon::parse($e->end)->format('D, j M')) {
								$sameDay = true;
							} ?>
							
							<em class="text-muted">on</em>
							<?php echo Carbon::parse($e->start)->format('D, j M');?>
							<em class="text-muted">at</em>
							<?php echo Carbon::parse($e->start)->format('h:ia');?>

							<em class="text-muted">until</em>
							<?php if ($sameDay): ?>
								<?php echo Carbon::parse($e->end)->format('D, j M');?>
								<em class="text-muted">at</em>
							<?php endif; ?>
							<?php echo Carbon::parse($e->end)->format('h:ia');?>
						</span>
					</h5>
				</td>
			</tr>
		<?php endforeach; ?>

		<?php if (!count($events)): ?>
			<tr>
				<td class="text-muted" style="background-color: white">
					<em>No events upcoming.</em>
				</td>
			</tr>
		<?php endif; ?>
		</table>


		<br />
		<h4>Recent Posts</h4>

		<table class="table table-striped table-hover">
		<?php foreach ($posts as $p): ?>
			<tr class="table-row">
				<td class="table-cell">
					<h5>
						<?php if ($p->belongs_to_type == "classroom"): ?>
							<a href="<?php echo action("ClassroomController@show", $p->classroom->id);?>?show=discussion">
								<?php echo $p->name;?>
							</a>
							&nbsp; 
							<em class="text-muted"><?php echo $p->classroom->name;?></em>
						<?php elseif ($p->belongs_to_type == "event"): ?>
							<a href="<?php echo action("CalendarEventController@show", $p->event->id);?>">
								<?php echo $p->name;?>
							</a>
							&nbsp; 
							<em class="text-muted"><?php echo $p->event->name;?></em>
						<?php endif; ?>
						
						<span style="float: right">
							
							
							<em class="text-muted">on</em>
							<?php echo Carbon::parse($p->created_at)->format('D, j M');?>
							<em class="text-muted">at</em>
							<?php echo Carbon::parse($p->created_at)->format('h:ia');?>
						</span>
					</h5>
				</td>
			</tr>
		<?php endforeach; ?>

		<?php if (!count($posts)): ?>
			<tr>
				<td class="text-muted" style="background-color: white">
					<em>No recent posts.</em>
				</td>
			</tr>
		<?php endif; ?>
		</table>
	</div>



	<div class="col-xs-12 col-sm-4 push-down">
		

		<?php 
		$classesImIn = array();
		$classesImInHidden = array();
		$classesIRun = array();
		$classesIRunHidden = array();
		foreach (Auth::user()->classrooms as $c) {
			//echo $c;
			if ($c->is_admin()) {
				if (Carbon::parse($c->start_date)->gt(Carbon::now()) || Carbon::parse($c->end_date)->lt(Carbon::now())) {
					array_push($classesIRunHidden, $c);
				} else {
					array_push($classesIRun, $c);
				}
			} else {
				if (Carbon::parse($c->start_date)->gt(Carbon::now()) || Carbon::parse($c->end_date)->lt(Carbon::now())) {
					array_push($classesImInHidden, $c);
				} else {
					array_push($classesImIn, $c);
				}
			}
		} ?>



		<h4>Classes I Run</h4>

		<table class="table table-striped table-hover">
		<?php foreach ($classesIRun as $c): ?>
			<tr>
				<td>
					<a href="<?php echo action('ClassroomController@show', array($c->id));?>">
						<?php echo $c->name;?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if (count($classesIRunHidden)): ?>
		<tr>
			<td>
				<a href="<?php echo action('ClassroomController@index', array($c->id));?>">
					<em class="text-muted"><?php echo count($classesIRunHidden);?> more classes hidden</em>
				</a>
			</td>
		</tr>
		<?php endif; ?>
		<?php if (!count($classesIRun)):?>
			<tr>
				<td class="text-muted" style="background-color: white">
					<em>none</em>
				</td>
			</tr>
		<?php endif; ?>
		</table>

		<br />






		<h4>
			Classes I'm In
		</h4>

		<table class="table table-striped table-hover">
		<?php foreach ($classesImIn as $c): ?>
			<tr>
				<td>
					<a href="<?php echo action('ClassroomController@show', array($c->id));?>">
						<?php echo $c->name;?>
					</a>
				</td>
			</tr>
			
		<?php endforeach; ?>
		<tr>
			<?php if (count($classesImInHidden)): ?>
			<td>
				<a href="<?php echo action('ClassroomController@index', array($c->id));?>">
					<em class="text-muted"><?php echo count($classesImInHidden);?> more classes hidden</em>
				</a>
			</td>
			<?php endif; ?>
		</tr>
		<?php if (!count($classesImIn)):?>
			<tr>
				<td class="text-muted" style="background-color: white">
					<em>none</em>
				</td>
			</tr>
		<?php endif; ?>
		</table>

		<br />

		


	</div>


</div>