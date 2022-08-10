
<?php echo Form::open(['action' => ['ClassroomController@update', $classroom->id], 'method' => 'put', 'class' => 'form ajax-modal-form']);?>

	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h4 class="modal-title">
			Edit Class: <span class="text-muted"><?php echo $classroom->name;?></span>
		</h4>
	</div>



	<div class="modal-body">

		<?php echo Form::token();?>


		<div class="form-group">
			<label for="name">Name</label>
			<input class="form-control" type="text" id="name" name="name" placeholder="Class Name" value="<?php echo $classroom->name;?>">
			<p class="help-block"></p>
		</div>

		<div class="form-group">
			<label for="code">Course Code</label>
			<input class="form-control" type="text" id="code" name="code" placeholder="PSYCH-101" value="<?php echo $classroom->code;?>">
			<p class="help-block"></p>
		</div>


		<div class="form-group">
			<label for="description">Class description</label>
			<textarea class="form-control" rows="5" type="text" id="description" name="description" placeholder="Describe your class here"><?php echo $classroom->description;?></textarea>
			<p class="help-block"></p>
		</div>




		<div class="row">
			<div class="form-group col-sm-6">
				<label for="start_date">Start Date</label>
				<input class="form-control datepicker" name="start_date" size="10" type="text" value="<?php echo Carbon::parse($classroom->start_date)->format("m-d-Y");?>">
				<span class="add-on"><i class="icon-calendar"></i></span>

				<p class="help-block"></p>
			</div>

			<div class="form-group col-sm-6">
				<label for="end_date">End Date</label>
				<input class="form-control datepicker" name="end_date" size="10" type="text" value="<?php echo Carbon::parse($classroom->end_date)->format("m-d-Y");?>">
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

		<button class="btn btn-success" type="submit">Save Changes</button>
	</div>

<?php echo Form::close();?>
