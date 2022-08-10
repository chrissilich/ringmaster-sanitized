<form class="form ajax-modal-form" method="POST" action="<?php echo action('AssignmentController@store', [$classroom->id]);?>" novalidate>
	

	<?php echo Form::token();?>
	
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h4 class="modal-title">
			<span class="glyphicon glyphicons-pushpin glyphicon-book text-primary" aria-hidden="true"></span>&nbsp;
			Create an Assignment
		</h4>
	</div>



	<div class="modal-body">

		<input type="hidden" id="classroom_id" name="classroom_id" value="<?php echo $classroom->id;?>">

		<div class="form-group">
			<label for="name">Name</label>
			<?php echo Form::text('name', '', array('placeholder' => "Assignment Name", 'class' => 'form-control'));;?>
			<p class="help-block"></p>
		</div>


		<div class="form-group">
			<label for="content">Content</label>
			<?php echo Form::textarea('content', '', array('placeholder' => "Assignment description", 'class' => 'form-control'));;?>
			<p class="help-block"></p>
		</div>


		<div class="row">
			<div class="form-group col-xs-6 col-sm-6">
				<label for="due_time">Due Time</label>
				<?php echo Form::text('due_time', (Carbon::now()->hour + 1) . ":00", array('class' => 'form-control timepicker'));?>
				<p class="help-block"></p>
			</div>
			<div class="form-group col-xs-6 col-sm-6">
				<label for="due_date">Due Date</label>
				<?php echo Form::text('due_date', Carbon::now()->format("m-d-Y"), array('class' => 'form-control datepicker'));?>
				<span class="add-on"><i class="icon-calendar"></i></span>
				<p class="help-block"></p>
			</div>
		</div>



		<div class="form-group">
			<?php echo Form::checkbox('has_submissions', 'true', true);?>
			<label for="has_submissions">
				&nbsp;Requires submissions?
			</label>
			<p class="help-block"></p>
		</div>


		<div class="form-group">
			<?php echo Form::checkbox('alert', 'true', true);?>
			<label for="alert">&nbsp;Email students in this class about this assignment?</label>
			
			<p class="help-block"></p>
		</div>




	</div>
	<div class="modal-footer">

		<a class="btn btn-default" data-dismiss="modal">Cancel</a>

		<button class="btn btn-success" type="submit">Create Assignment</button>
	</div>

</form>