$(document).ready(function(){
	$("#setup_departments li input[type='checkbox']").on("click", function() {
		if ($(this).is(":checked")) {
			var $thing = $(this);
			while($thing.parent().length) {
				//console.log($thing);
				if ($thing.is("li")) {
					$thing.find("> label > input[type='checkbox']").prop('checked', true);
				}
				$thing = $thing.parent();
			}
		}
	})
});