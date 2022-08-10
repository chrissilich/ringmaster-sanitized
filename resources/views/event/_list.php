<table class="table">
<?php if (count($events)): foreach ($events as $i => $e):?>
<?php
	$past = "";
	if (Carbon::parse($e->start)->isPast()) {
		$past = " past ";
	}
?>
	<tr class="<?php echo $past;?>"><td class="<?php echo $i;?>">
		<h4 class="col-xs-12 col-sm-8">
			<a class="ajax-modal" href="<?php echo action('CalendarEventController@show', array($e->id));?>">
				<?php echo $e->name;?>
			</a>
		</h4>
		<h5 class="col-xs-12 col-sm-4 text-muted text-right">
			<em>
				<?php if (Carbon::parse($e->start)->toFormattedDateString() == Carbon::parse($e->end)->toFormattedDateString()) {
					// same day
					echo Carbon::parse($e->start)->format("g:ia");
					echo " &mdash; ";
					echo Carbon::parse($e->end)->format("g:ia");
					echo "<br />";
					echo Carbon::parse($e->start)->toFormattedDateString();
				} else {
					// different day
					echo Carbon::parse($e->start)->toDayDateTimeString();
					echo "<br /> &mdash; ";
					echo Carbon::parse($e->end)->toDayDateTimeString();
				} ?>
			</em>
		</h5>
		<p class="col-xs-12">
			<?php echo nl2br($e->content);?>
		</p>
		<p class="small text-muted col-xs-12">
			<em>
				Posted by <?php echo $e->owner->prettyName();?>
			</em>
		</p>
	</td></tr>
<?php endforeach; else: ?>
	<p>No events yet.</p>
<?php endif; ?>
</table>