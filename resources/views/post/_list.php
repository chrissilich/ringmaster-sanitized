<table class="table">
	<?php if (count($posts)): ?>
		<?php $posts->each(function($p) { ?>
			<tr>
				<td>
					<h5>
						<a class="ajax-modal" href="<?php echo action("PostController@show", $p->id);?>"><?php echo $p->name;?></a>
					</h5>
					<h6>
						<?php echo count($p->posts);?> comments
					</h6>
					<p class="small text-muted">
						<em>
							<?php if ($p->owner): ?>
								Posted by <?php echo $p->owner->prettyName();?> on 
							<?php endif; ?>
							<?php 
								echo Carbon::parse($p->created_at)->format("g:ia");
								echo ", ";
								echo Carbon::parse($p->created_at)->toFormattedDateString();
							?>
						</em>
					</p>
					<div class="read-more"><?php echo nl2br($p->content);?></div>
					
				</td>
			</tr>
		<?php });?>
	<?php else: ?>
		<p>No posts yet.</p>
	<?php endif; ?>
</table>