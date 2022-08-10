
<form class="form ajax-modal-form" method="POST" action="<?php echo action('ClassroomController@store');?>" novalidate>

	<?php echo Form::token();?>

	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h4 class="modal-title">
			Create a Class
		</h4>
	</div>



	<div class="modal-body">



		<div class="form-group">
			<label for="name">Name</label>
			<input class="form-control" type="text" id="name" name="name" placeholder="Class Name" value="<?php echo Request::old('name');?>">
			<p class="help-block"></p>
		</div>

		<div class="form-group">
			<label for="code">Course Code</label>
			<input class="form-control" type="text" id="code" name="code" placeholder="PSYCH-101" value="<?php echo Request::old('code');?>">
			<p class="help-block"></p>
		</div>


		<div class="form-group">
			<label for="description">Class description</label>
			<textarea class="form-control" rows="5" type="text" id="description" name="description" placeholder="Describe your class here"><?php echo Request::old('description');?></textarea>
			<p class="help-block"></p>
		</div>




		<div class="row">
			<div class="form-group col-sm-6">
				<label for="start_date">Start Date</label>
				<input class="form-control datepicker" name="start_date" size="10" type="text" value="<?php echo Carbon::now()->format("m-d-Y");?>">
				<span class="add-on"><i class="icon-calendar"></i></span>

				<p class="help-block"></p>
			</div>

			<div class="form-group col-sm-6">
				<label for="end_date">End Date</label>
				<input class="form-control datepicker" name="end_date" size="10" type="text" value="<?php echo Carbon::now()->addWeeks(11)->format("m-d-Y");?>">
				<span class="add-on"><i class="icon-calendar"></i></span>

				<p class="help-block"></p>
			</div>

			<p class="col-sm-12 text-muted">
				Outside these dates, class will be hidden.
			</p>
		</div>



	


	</div>
	<div class="modal-footer">

		<a class="btn btn-default" data-dismiss="modal">Cancel</a>

		<button class="btn btn-success" type="submit">Create Class</button>
	</div>

</form>