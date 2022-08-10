<script>
	var ajaxGradeSaveURI = "<?php echo action('GradeController@update');?>";
	var ajaxWeightSaveURI = "<?php echo action('AssignmentController@weight', [$classroom->id]);?>";
</script>


<table id="grades" class="admin table table-responsive table-condensed table-striped table-hover">
	<tr>
		<th>Name</th>
		<?php foreach ($classroom->assignments as $a): ?>
			<th data-assignment-id="<?php echo $a->id;?>" class="assignment-header"><?php echo $a->name;?></th>
		<?php endforeach; ?>
		<th>Total Calculated</th>
	</tr>

	<?php foreach ($classroom->users as $u): ?>
		<tr class="grade-row">
			<td><?php echo $u->prettyName();?></td>
			<?php foreach ($classroom->assignments as $a): ?>
				<td data-assignment-id="<?php echo $a->id;?>">
					<?php $grade = App\Models\Grade::where('user_id', '=', $u->id)->where('assignment_id', '=', $a->id)->get()->first();?>
					<input 
						class="grade form-control"
						data-assignment-id="<?php echo $a->id;?>" 
						data-user-id="<?php echo $u->id;?>" 
						value="<?php if ($grade && is_numeric($grade->grade)) echo $grade->grade;?>">
					
					<textarea 
						class="form-control <?php if ($grade && $grade->comment) echo "commented";?>" 
						rows=3
						data-assignment-id="<?php echo $a->id;?>" 
						data-user-id="<?php echo $u->id;?>"><?php if ($grade) echo $grade->comment;?></textarea>				
				</td>
			<?php endforeach; ?>
			<td class="calculated" style="font-weight: bold"></td>
		</tr>
	<?php  endforeach; ?>

	<tr class="weight-row">
		<th>Weight:</th>
		<?php foreach ($classroom->assignments as $a): ?>
			<th data-assignment-id="<?php echo $a->id;?>">
				<input value="<?php if ($a->weight && is_numeric($a->weight)) { echo $a->weight;};?>" class="weight form-control" data-assignment-id="<?php echo $a->id;?>">	
			</th>
		<?php endforeach; ?>
		<th class="calculated"></th>
	</tr>


</table>

<a href="javascript:;" class="hide-zeros btn btn-default">Hide Zero Weight Assignments?</a>
<a href="javascript:;" class="show-zeros btn btn-default">Show All Assignments?</a>

