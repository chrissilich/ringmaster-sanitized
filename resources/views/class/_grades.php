
<table id="grades" class="table table-responsive table-condensed table-striped table-hover">
	<thead>
		<tr>
			<th>Assignment</th>
			<th>Grade</th>
			<th>Weight</th>
			<th>Comment</th>
		</tr>
	</thead>

	<?php 
		$weights_total = 0;
		$calculated_total = 0;
	?>
	<?php foreach ($classroom->assignments as $a): ?>
		<?php $grade = App\Models\Grade::where('user_id', '=', Auth::user()->id)->where('assignment_id', '=', $a->id)->get()->first();?>
		<tr>
			<td>
				<?php echo $a->name;?>
			</td>
			<td>
				<?php if ($grade && $grade->grade && is_numeric($grade->grade)) echo $grade->grade; ?>					
			</td>
			<td>
				<?php if ($a->weight && is_numeric($a->weight)): ?>
					<?php echo $a->weight;?>
					<?php 
						$weights_total += $a->weight;
						if ($grade && $grade->grade && is_numeric($grade->grade)) $calculated_total += ($grade->grade * $a->weight);
					?>
				<?php endif; ?>
			</td>
			<td style="width: 50%">
				<?php if ($grade && $grade->comment) echo $grade->comment; ?>					
			</td>
		</tr>
	<?php endforeach; ?>

	<tfoot style="border-top: 2px solid #ddd; font-weight: bold">
		<tr>
			<td>
				Total Calculated
			</td>
			
			<td>
				<?php if ($calculated_total && $weights_total) echo $calculated_total/$weights_total;?>	
			</td>
			<td>
				<?php echo $weights_total;?>
			</td>
			<td></td>
		
		</tr>
	</tfoot>	
</table>
<?php /*
*/ ?>