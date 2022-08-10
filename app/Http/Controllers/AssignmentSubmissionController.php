<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;


use App\Models\Assignment;
use App\Models\Upload;
use App\Models\AssignmentSubmission;

use Auth, View, Request, Validator, Response;


class AssignmentSubmissionController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }



	public function create() {
		if (!array_key_exists("assignment_id", $_GET)) {
			return Redirect::back();
		}
	
		$data = array(
			"assignment" => Assignment::findOrFail($_GET["assignment_id"])
		);
		return View::make('template', $data)->nest('content', 'assignment.submission.create', $data);
	}



	public function store() {
		

		if (!Request::input('content') && !Request::input('upload_ids'))
		{
			return Response::json(array(
				"status" 	=> "fail",
				"data" 		=> array(
					"validation" 	=> [
						"content" => ["You have to at least submit some text, a file, or both."]
					]
				)
			));

		} else {

			// return Request::all();
			$assignment = Assignment::findOrFail( Request::input('assignment_id') );
				
			$assignmentSubmission = new AssignmentSubmission;
			$assignmentSubmission->content = 			Request::input('content');
			$assignmentSubmission->assignment_id = 		Request::input('assignment_id');
			$assignmentSubmission->owner_id = 			Auth::user()->id;

			if ($assignmentSubmission->save()) {
				
				if ( Request::input('upload_ids')) {
					$uploadIDs = explode(",", Request::input('upload_ids'));
					foreach ($uploadIDs as $uid) {
						$upload = Upload::find($uid);
						if ($upload && $upload->owner_id === Auth::user()->id) {
							$upload->belongs_to_type = "assignment_submission";
							$upload->belongs_to_id = $assignmentSubmission->id;
							if (!$upload->save()) {
								return Response::json(array(
									"status" 	=> "error",
									"message" 	=> "new-assignment-submission-upload-association-save"
								), 400);
							}
						} else if (!$upload) {
							return Response::json(array(
								"status" 	=> "error",
								"message" 	=> "new-assignment-submission-upload-not-found"
							), 401);
						} else {
							return Response::json(array(
								"status" 	=> "error",
								"message" 	=> "new-assignment-submission-upload-claim-user-mismatch"
							), 401);
						}
					}
				}

				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> null
				));


				
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "new-assignment-submission-save"
				), 400);
			}
			
		}
		
	}



}
