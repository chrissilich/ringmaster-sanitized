
<form class="form ajax-modal-form" method="POST" action="<?php echo action('ClassroomController@storejoin');?>" novalidate>
		
	<?php echo Form::token();?>

	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h4 class="modal-title">
			Join a Class
		</h4>
	</div>



	<div class="modal-body">



		<div class="form-group">
			<label for="join_code">Join Code</label>
			<p>Ask your teacher for the "join code" for this class.</p>
			<input class="form-control" type="text" id="join_code" name="join_code" placeholder="two words" value="<?php echo Request::old('join_code');?>">
			<p class="help-block"></p>
		</div>



	</div>
	<div class="modal-footer">

		<a class="btn btn-default" data-dismiss="modal">Cancel</a>

		<input class="btn btn-success" type="submit" value="Join Class">
	</div>

</form>