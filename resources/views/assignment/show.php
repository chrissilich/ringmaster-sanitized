
<?php echo Form::open(array(
	"class" => "form ajax-modal-form",
	"url" => action('AssignmentSubmissionController@store', [$assignment->classroom->id, $assignment->id]),
	"files" => true
));?>

<input type="hidden" id="assignment_id" name="assignment_id" value="<?php echo $assignment->id;?>">


	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		
		<h4 class="modal-title">
			<span class="glyphicon glyphicons-pushpin glyphicon-book text-primary" aria-hidden="true"></span>&nbsp;
			<?php echo $assignment->name;?><br />
			<small><?php echo View::make('breadcrumbs', array("reverse" => true, "skip_first" => true, "end" => $assignment));?></small>
		</h4>
	</div>



	<div class="modal-body">
		
		<h5>Description</h5>
		<p>
			<?php echo nl2br($assignment->content); ?>
		</p>

		<?php if ($assignment->classroom->is_admin()): ?>
			<?php if ($assignment->has_submissions):?>
				<br /><br />
				<h5>This assignment requires a submission.</h5>
				<p>
					...and it's due <?php echo Carbon::parse($assignment->due)->diffForHumans();?> (<?php echo Carbon::parse($assignment->due)->toDayDateTimeString();?>)
				</p>
			<?php endif; ?>
			
		<?php elseif ($assignment->has_submissions && $assignment->classroom->is_member()): ?>
			<br /><br />
			<h5>This assignment requires a submission.</h5>
			<p>
				...and it's due <?php echo Carbon::parse($assignment->due)->diffForHumans();?> (<?php echo Carbon::parse($assignment->due)->toDayDateTimeString();?>)
			</p>

			
			<?php if (count($assignment->myAssignmentSubmissions)): ?>
				<p>
					You've already submitted something for this assignment. You can resubmit, but the teacher will have both versions.
				</p>				
			<?php endif; ?>

			<br>
			<label for="">
				Files<br>
				<small style="font-weight: 400; opacity: 0.75">(max 20 files, 200mb each, any file type)</small>
			</label>
			<?php echo View::make('upload-modern._dropzone'); ?>


			<label for="submission-content">
				Text<br>
				<small style="font-weight: 400; opacity: 0.75">(max 400 characters; if it's more than a couple of sentences, make a document and upload it)</small>
			</label>
			<textarea class="form-control" type="text" maxlength="400" id="submission-content" name="content" placeholder="" value="<?php echo Request::old('content');?>" rows="2"></textarea>
			

			<p class="help-block"></p>
			


		<?php elseif ($assignment->has_submissions && !$assignment->classroom->is_member()):?>
			<p>
				This assignment requires submissions, but you're not in the class... how did you get here?
			</p>


		<?php else: ?>
			<p>
				The teacher did not set this assignment to accept submissions through Ringmaster.
			</p>

		<?php endif;?>




		<br /><br />

		

		<?php if ($assignment->classroom->is_admin()): ?>

			<h5>Submissions</h5>
			<div class="table-responsive">
				<table class="table ">
					<thead>
						<th>Student</th>
						<th>Content</th>
						<th>File(s)</th>
						<th>Date</th>
					</th>
				<?php foreach ($assignment->classroom->users as $user): ?>
					<?php 
					$assignmentSubmissions = App\Models\AssignmentSubmission::ofAssignment($assignment->id)->ofOwner($user->id)->get();
					foreach ($assignmentSubmissions as $i => $assignmentSubmission): ?>
						<tr>
							<td style="min-width: 100px;"><?php if (!$i) echo $user->prettyName();?></td>
							<td><?php echo $assignmentSubmission->content;?></td>
							<td>
								<?php foreach ($assignmentSubmission->uploads as $i => $upload): ?>
									<?php if($i):?><br /><?php endif; ?>
									<a target="_blank" href="<?php echo URL::to(Config::get('ringmaster.uploads_url_path')."/".$upload->new_filename);?>">
										<?php echo $upload->filename;?>
									</a>
								<?php endforeach; ?>							
							</td>
							<td style="min-width: 100px;" class="<?php echo (Carbon::parse($assignmentSubmission->created_at) > Carbon::parse($assignment->due))?"danger":"success";?>">
								<?php echo Carbon::parse($assignmentSubmission->created_at)->toDayDateTimeString();?>
							</td>
						</tr>
					<?php endforeach; ?>
					<?php if (!count($assignmentSubmissions) && $user->id != Auth::user()->id): ?>
						<tr>
							<td><?php echo $user->prettyName();?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php endif; ?>
					
				<?php endforeach; ?>
				</table>
			</div>



		<?php else:?>

			<h5>Your Submissions</h5>

			<table class="table">
				<thead>
					<th>Content</th>
					<th>File(s)</th>
					<th>Date</th>
				</th>
				<?php 
				$assignmentSubmissions = App\Models\AssignmentSubmission::ofAssignment($assignment->id)->ofOwner(Auth::user()->id)->get();
				foreach ($assignmentSubmissions as $i => $assignmentSubmission): ?>
					<tr>
						<td><?php echo $assignmentSubmission->content;?></td>
						<td>
							<?php foreach ($assignmentSubmission->uploads as $i => $upload): ?>
								<?php if($i):?><br /><?php endif; ?>
								<a target="_blank" href="<?php echo URL::to(Config::get('ringmaster.uploads_url_path')."/".$upload->new_filename);?>">
									<?php echo $upload->filename;?>
								</a>
							<?php endforeach; ?>							
						</td>
						<td class="<?php echo (Carbon::parse($assignmentSubmission->created_at) > Carbon::parse($assignment->due))?"danger":"success";?>">
							<?php echo Carbon::parse($assignmentSubmission->created_at)->toDayDateTimeString();?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

		<?php endif; ?>
	
	</div>


	<div class="modal-footer">

		<?php if ($assignment->classroom->is_admin()): ?>
			<a class="btn btn-danger btn-sm ajax-simple" method="delete" style="float: left" href="<?php echo action('AssignmentController@destroy', [$assignment->classroom->id, $assignment->id]);?>">Delete Assignment</a>
			<a class="btn btn- btn-sm ajax-modal" style="float: left" href="<?php echo action('AssignmentController@edit', [$assignment->classroom->id, $assignment->id]);?>">Edit Assignment?</a>
		<?php endif; ?>

		<a class="btn btn-default" data-dismiss="modal">Close</a>
		<?php if ($assignment->classroom->is_member()): ?>
			<input id="assignment-submit" class="btn btn-success" type="submit" value="Submit Assignment">
		<?php endif; ?>
	</div>

</form>