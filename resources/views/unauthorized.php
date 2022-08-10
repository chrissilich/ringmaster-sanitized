<?php if (Request::ajax()) {
	echo json_encode([
		"status" 	=> "fail",
		"data" 		=> [
			"message" => [
				"content" => "Unauthorized",
				"ttl" => 10,
				"classes" => "alert alert-danger"
			]
		]
	]);
} else { 
	echo "Unauthorized";
};
?>