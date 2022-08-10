<?php 

$items = array();
if (!isset($reverse)) $reverse = false;
if (!isset($skip_first)) $skip_first = false;

if (!function_exists('showItem')) {
	function showItem($item, $end = false, $reverse, $skip = false) { ?>
		<?php if (get_class($item) == "Classroom"):?>
			<?php if (!$reverse && $item->parent) {
				showItem($item->parent, $end, $reverse);
				if (!$skip) echo " / ";
			} ?>
			<?php if (!$skip): ?><a href="<?php echo action("ClassroomController@show", $item->id);?>">
				<?php if ($end): ?><strong><?php endif; ?>
					<?php echo $item->name;?>
				<?php if ($end): ?></strong><?php endif; ?>
			</a><?php endif; ?>
			<?php if ($reverse && $item->parent) {
				if (!$skip) echo " / ";
				showItem($item->parent, $end, $reverse);
			} ?>

		<?php elseif (get_class($item) == "Assignment"):?>
			<?php if (!$reverse && $item->classroom()) {
				showItem($item->classroom, $end, $reverse);
				if (!$skip) echo " / ";
			} ?>
			<?php if (!$skip): ?><a href="<?php echo action("AssignmentController@show", [$item->classroom->id, $item->id]);?>">
				<?php if ($end): ?><strong><?php endif; ?>
					<?php echo $item->name;?>
				<?php if ($end): ?></strong><?php endif; ?>
			</a><?php endif; ?>
			<?php if ($reverse && $item->classroom()) {
				if (!$skip) echo " / ";
				showItem($item->classroom, $end, $reverse);
			} ?>

		<?php elseif (get_class($item) == "CalendarEvent"):?>
			<?php if (!$reverse && $item->classroom()) {
				showItem($item->classroom, $end, $reverse);
				if (!$skip) echo " / ";
			} ?>
			<?php if (!$skip): ?><a href="<?php echo action("CalendarEventController@show", $item->id);?>">
				<?php if ($end): ?><strong><?php endif; ?>
					<?php echo $item->name;?>
				<?php if ($end): ?></strong><?php endif; ?>
			</a><?php endif; ?>
			<?php if ($reverse && $item->classroom()) {
				if (!$skip) echo " / ";
				showItem($item->classroom, $end, $reverse);
			} ?>

		<?php elseif (get_class($item) == "Post"):?>
			<?php if (!$reverse && $item->classroom()) {
				showItem($item->classroom, $end, $reverse);
				if (!$skip) echo " / ";
			} elseif (!$reverse && $item->event()) {
				showItem($item->event, $end, $reverse);
				if (!$skip) echo " / ";
			} elseif (!$reverse && $item->post()) {
				showItem($item->parentPost, $end, $reverse);
				if (!$skip) echo " / ";
			} ?>
			<?php if (!$skip): ?><a href="<?php echo action("PostController@show", $item->id);?>">
				<?php if ($end): ?><strong><?php endif; ?>
					<?php echo $item->name;?>
				<?php if ($end): ?></strong><?php endif; ?>
			</a><?php endif; ?>
			<?php if ($reverse && $item->classroom()) {
				if (!$skip) echo " / ";
				showItem($item->classroom, $end, $reverse);
			} elseif ($reverse && $item->event()) {
				if (!$skip) echo " / ";
				showItem($item->event, $end, $reverse);
			} elseif ($reverse && $item->post()) {
				if (!$skip) echo " / ";
				showItem($item->parentPost, $end, $reverse);
			} ?>
		<?php endif; ?>
	<?php };
}; 



showItem($end, true, $reverse, $skip_first);

?>