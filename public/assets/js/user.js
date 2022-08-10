$(document).ready(function(){
	
	$(".upgrade_user").on("change", function() {
		var userID = parseInt($(this).attr("data-user-id"));
		var newLevel = $(this).val();
		var $current = $(this).parents("td").find(".current");
		console.log("change " + userID + " to " + newLevel);

		$.ajax(LEVEL_CHANGE_SERVICE_URI.replace(-1, userID) + "/" + newLevel).done(function(msg) {
			if (msg == "Error" || msg == "Unauthorized") {
				// TODO: use a popup or something to show this error
			}
			$current.text(msg.toTitleCase());
		});
		
	})

});