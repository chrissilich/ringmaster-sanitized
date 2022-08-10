

<h1>Event list</h1>
<ul>
	<?php $events->each(function($e) { ?>
		<li>
			<h3><?php echo $e->id;?>. <?php echo $e->name;?></h3>
			<p><?php echo $e->description;?></p>
			<p>Created by <?php echo $e->owner->email;?></p>
		</li>
	<?php });?>
</ul>