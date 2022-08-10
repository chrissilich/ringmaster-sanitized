<form class="form ajax-modal-form" method="POST" action="<?php echo action('PostController@store');?>" novalidate>
	
	<?php echo Form::token();?>

	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h4 class="modal-title">
			Post Something
		</h4>
	</div>



	<div class="modal-body">

			
			<input type="hidden" id="belongs_to_type" name="belongs_to_type" value="<?php echo $type;?>">
			<input type="hidden" id="belongs_to_id" name="belongs_to_id" value="<?php echo $id;?>">
			
			<div class="form-group">
				<label for="name">Post title</label>
				<?php echo Form::text('name', '', array('placeholder' => "Post Title", 'class' => 'form-control'));;?>
				<p class="help-block"></p>
			</div>


			<div class="form-group">
				<label for="content">Post content</label>
				<?php echo Form::textarea('content', '', array('placeholder' => "Post Content", 'class' => 'form-control'));;?>
				<p class="help-block"></p>
			</div>



			<div class="form-group">
				<?php echo Form::checkbox('alert', 'true', true);;?>
				<label for="alert">&nbsp;
					<?php if ($type == "classroom"): ?>
						Email students in this class about this post?
					<?php elseif ($type == "event"): ?>
						<?php if ($location->classroom()): ?>
							Email people in the class that this event is hosted by about this post?
						<?php endif;?>
						
					<?php elseif ($type == "post"): ?>
						Email subscribers to this thread about this post?
					<?php endif; ?>
				</label>
				
			</div>





	</div>
	<div class="modal-footer">

		<a class="btn btn-default" data-dismiss="modal">Cancel</a>

		<button class="btn btn-success" type="submit">Post</button>
	</div>


</form>