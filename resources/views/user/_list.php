<?php // dep ?>

<table class="table">
<?php foreach ($users as $i => $u):?>
	<tr class="">
		<td>
			<h3><?php echo $u->prettyName();?></h3>
		</td>
	</tr>
<?php endforeach; ?>
</table>