
<form class="form ajax-modal-form" method="POST" action="<?php echo action('CalendarEventController@store');?>" novalidate>

	<?php echo Form::token();?>
	
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h4 class="modal-title">
			Create an Event
		</h4>
	</div>



	<div class="modal-body">
		
	
		<input type="hidden" id="belongs_to_type" name="belongs_to_type" value="<?php echo $type;?>">
		<input type="hidden" id="belongs_to_id" name="belongs_to_id" value="<?php echo $id;?>">


		<div class="form-group">
			<label for="name">Name</label>
			<?php echo Form::text('name', '', array('placeholder' => "Event Name", 'class' => 'form-control'));;?>
			<p class="help-block"></p>
		</div>


		<div class="form-group">
			<label for="content">Content</label>
			<?php echo Form::textarea('content', '', array('placeholder' => "Event description", 'class' => 'form-control'));;?>
			<p class="help-block"></p>
		</div>

		<div class="row">
			<div class="form-group col-xs-6 col-sm-3">
				<label for="start_time">Start Time</label>
				<?php echo Form::text('start_time', Carbon::now()->hour.":".(Carbon::now()->quarter * 15), array('class' => 'form-control timepicker'));?>
				<p class="help-block"></p>
			</div>
			<div class="form-group col-xs-6 col-sm-3">
				<label for="start_date">Start Date</label>
				<?php echo Form::text('start_date', Carbon::now()->format("m-d-Y"), array('class' => 'form-control datepicker'));?>
				<span class="add-on"><i class="icon-calendar"></i></span>
				<p class="help-block"></p>
			</div>


			<div class="form-group col-xs-6 col-sm-3">
				<label for="end_time">End Time</label>
				<?php echo Form::text('end_time', (Carbon::now()->hour+1).":".(Carbon::now()->quarter * 15), array('class' => 'form-control timepicker'));?>
				<p class="help-block"></p>
			</div>
			<div class="form-group col-xs-6 col-sm-3">
				<label for="end_date">End Date</label>
				<?php echo Form::text('end_date', Carbon::now()->format("m-d-Y"), array('class' => 'form-control datepicker'));?>
				<span class="add-on"><i class="icon-calendar"></i></span>
				<p class="help-block"></p>
			</div>


			
		</div>

		<div class="form-group">
			<?php echo Form::checkbox('alert', 'true', true);;?>
			<label for="alert">
				<?php if ($type == "classroom"):?>
					&nbsp;Email students in this class about this event?
				<?php endif; ?>

			</label>
			
			<p class="help-block"></p>
		</div>




	</div>
	<div class="modal-footer">

		<a class="btn btn-default" data-dismiss="modal">Cancel</a>

		<button class="btn btn-success" type="submit">Create Event</button>
	</div>

</form>