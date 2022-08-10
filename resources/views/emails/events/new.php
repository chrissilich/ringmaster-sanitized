<h1>Ringmaster</h1>
<h2>
	New Event: 
	<a href="<?php echo action("CalendarEventController@show", $event->id);?>">
		<?php echo $event->name;?>
	</a>
</h2>
<h3>
	<?php if ($event->classroom()): ?>
		Class: 
		<a href="<?php echo action("ClassroomController@show", $event->classroom->id);?>">
			<?php echo $event->classroom->name;?>
		</a>
	<?php endif; ?>
</h3>
<p>
	<?php echo nl2br($event->content);?>
</p>
<p>
	<?php if (Carbon::parse($event->start)->toFormattedDateString() == Carbon::parse($event->end)->toFormattedDateString()) {
		// same day
		echo Carbon::parse($event->start)->format("g:ia");
		echo " &mdash; ";
		echo Carbon::parse($event->end)->format("g:ia");
		echo "<br />";
		echo Carbon::parse($event->start)->toFormattedDateString();
	} else {
		// different day
		echo Carbon::parse($event->start)->toDayDateTimeString();
		echo "<br /> &mdash; ";
		echo Carbon::parse($event->end)->toDayDateTimeString();
	} ?>
</p>
<?php /*
<p>
	This message was sent to: <?php foreach ($emails as $e): ?>
		<?php echo $e;?>
	<?php endforeach; ?>
</p>
*/ ?>