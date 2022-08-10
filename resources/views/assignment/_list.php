<table class="table">
<?php if (count($assignments)): foreach ($assignments as $i => $a):?>
	<?php
		$past = "";
		if (Carbon::parse($a->due)->isPast()) {
			$past = " past ";
		}
	?>
	<tr class="<?php echo $past;?> assignment <?php echo $i;?>">
		<td>
			<h4 class="col-xs-12">
				<a class="ajax-modal" href="<?php echo action('AssignmentController@show', [$a->classroom->id, $a->id]);?>">
					<?php echo $a->name;?>
				</a>
			</h4>
			<div class="col-xs-12 col-sm-6">
				<p>
					<?php echo nl2br($a->content);?>
				</p>
				<?php if ($a->owner): ?>
					<p class="text-muted">
						Posted by <?php echo $a->owner->prettyName();?>
					</p>
				<?php endif; ?>
			</div>

			<div class="col-xs-12 col-sm-3">
				<p>
					<b>
						Due:
					</b><br />
					<em>
						<?php echo Carbon::parse($a->due)->toFormattedDateString();?>, at <?php echo Carbon::parse($a->due)->format("g:ia"); ?>
					</em>
				</p>
			</div>
		</td>
	</tr>
<?php endforeach; else: ?>
	<p>No assignments yet.</p>
<?php endif; ?>
</table>