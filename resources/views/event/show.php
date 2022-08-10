<form class="form ajax-modal-form" method="POST" action="<?php echo action('PostController@store');?>" novalidate>

	<?php echo Form::token();?>
	
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h4 class="modal-title">
			<span class="glyphicon glyphicon-calendar text-primary" aria-hidden="true"></span>&nbsp; 
			<?php echo $event->name;?><br />
			<small><?php echo View::make('breadcrumbs', array("reverse" => true, "skip_first" => true, "end" => $event));?></small>
		</h4>
	</div>



	<div class="modal-body">

		
		<h5>Description</h5>
		<p>
			<?php echo nl2br($event->content); ?>
		</p>

		<h5>Time</h5>
		<p>
			<?php if (Carbon::parse($event->start)->toFormattedDateString() == Carbon::parse($event->end)->toFormattedDateString()) {
				// same day
				echo Carbon::parse($event->start)->format("g:ia");
				echo " &mdash; ";
				echo Carbon::parse($event->end)->format("g:ia");
				echo ", ";
				echo Carbon::parse($event->start)->toFormattedDateString();
			} else {
				// different day
				echo Carbon::parse($event->start)->format("g:ia, D, NS M Y");
				echo " &mdash; ";
				echo Carbon::parse($event->end)->format("g:ia, D, NS M Y");
			} ?>
		</p>

		





		<br /><br />

		<h5>
			Comments
		</h5>


		<?php if (!count($event->posts)): ?>
			No comments yet...
		<?php endif; ?> 

		
		<input type="hidden" id="belongs_to_type" name="belongs_to_type" value="event">
		<input type="hidden" id="belongs_to_id" name="belongs_to_id" value="<?php echo $event->id;?>">
			
		<?php echo Form::hidden('name', 'Reply');?>

		<table class="table">
			<tr>
				<td>
					<?php echo Form::textarea('content', '', array('id' => 'comment', 'placeholder' => "Reply here...", 'class' => 'form-control', 'rows' => 2));;?>
					<p class="help-block"></p>
					<div id="comment-options">
						<?php echo Form::checkbox('alert', 'true');;?>
						<label for="alert">&nbsp;
							Email subscribers to this post about your reply?
						</label>
					</div>
					<script>
						$("#comment-options, #comment-submit").hide();
						$("#comment").on("focus", function() {
							$("#comment-options").slideDown();
							$("#comment-submit").fadeIn();
						})
					</script>
				</td>
			</tr>
		<?php $event->posts->each(function($p) {?>
			<tr>
				<td>
					<?php echo nl2br($p->content);?>
					<p class="small text-muted">
						<em>
							Posted by <?php echo $p->owner->prettyName();?> on 
							<?php 
								echo Carbon::parse($p->created_at)->format("g:ia");
								echo ", ";
								echo Carbon::parse($p->created_at)->toFormattedDateString();
							?>
						</em>
					</p>
				</td>
			</tr>
		<?php }); ?>
		</table>



	</div>
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">Close</button>
		<input id="comment-submit" class="btn btn-success" type="submit" value="Submit Reply">	
	</div>



</form>