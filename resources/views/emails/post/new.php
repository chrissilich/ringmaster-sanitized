<h1>Ringmaster</h1>
<h2>
	New Post: 
	<a href="<?php echo action("PostController@show", $post->id);?>">
		<?php echo $post->name;?>
	</a>
</h2>
<h3>
	<?php if ($post->classroom()): ?>
		Class: 
		<a href="<?php echo action("ClassroomController@show", $post->classroom->id);?>">
			<?php echo $post->classroom->name;?>
		</a>
	<?php elseif ($post->parentPost()): ?>
		Post: 
		<a href="<?php echo action("PostController@show", $post->parentPost->id);?>">
			<?php echo $post->parentPost->name;?>
		</a>
	<?php endif; ?>
</h3>
<p>
	<?php echo nl2br($post->content);?>
</p>
<p>
	This message was sent to: <?php foreach ($emails as $e): ?>
		<?php echo $e;?>
	<?php endforeach; ?>
</p>