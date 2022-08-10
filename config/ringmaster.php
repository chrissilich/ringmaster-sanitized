<?php
return array(
	'version' 				=> "1.2.4",
	'alert_email' 			=> 'no-reply@creativecircus.edu', // these are also in the mail config
	'alert_name' 			=> 'Ringmaster', // these are also in the mail config
	
	'uploads_path' 			=> env('UPLOADS_PATH', '/home/www/ringmaster.creativecircus.edu/public/uploads_volume/ringmaster_uploads'),
	'uploads_url_path' 		=> env('UPLOADS_URL', 'uploads_volume/ringmaster_uploads'),
);