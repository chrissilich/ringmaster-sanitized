<h1>Post list</h1>
<ul>
	<?php $posts->each(function($p) { ?>
		<li>
			<h3><?php echo $p->id;?>. <?php echo $p->name;?></h3>
			<p><?php echo $p->description;?></p>
			<p>Created by <?php echo $p->owner->email;?></p>
		</li>
	<?php });?>
</ul>