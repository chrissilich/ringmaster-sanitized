<h1>Ringmaster</h1>
<h2>
	New Assignment: 
	<a href="<?php echo action("ClassroomController@show", $assignment->classroom->id);?>?show=assignments">
		<?php echo $assignment->name;?>
	</a>
</h2>
<h3>
	Class: 
	<a href="<?php echo action("ClassroomController@show", $assignment->classroom->id);?>">
		<?php echo $assignment->classroom->name;?>
	</a>
</h3>
<p>
	<?php echo nl2br($assignment->content);?>
</p>
<p>
	Due: <?php echo Carbon::parse($assignment->due)->toFormattedDateString();?>, 
	at <?php echo Carbon::parse($assignment->due)->format("g:ia"); ?>
</p>
<?php if ($assignment->has_submissions):?>
<p>
	<b>There is a submission required for this assignment.</b>
</p>
<?php endif; ?>
<p>
	This message was sent to: <?php foreach ($emails as $e): ?>
		<?php echo $e;?>
	<?php endforeach; ?>
</p>