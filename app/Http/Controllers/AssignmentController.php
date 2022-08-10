<?php
namespace App\Http\Controllers;
use App\Models\Classroom;
use App\Models\Assignment;

use App\Http\Controllers\Controller;

use Auth, View, Request, Validator, Response, Mail, Config, Carbon;

class AssignmentController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        
        // TODO restrict all appropriate CRUD to class admins
        $this->middleware('csrf', array('only' => array(
        	'store'
        )));
    }




	/*
	public function index()
	{

		$data = array(
			"me" => Auth::user(),
			"events" => Assignment::all()
		);

		return View::make('template', $data)->nest('content', 'assignment.index', $data);
	}
	*/

	public function show($classroom_id, $id) {

		$assignment = Assignment::findOrFail($id);

		if ($assignment->classroom->id != $classroom_id) return View::make('unauthorized', 401);
		if (!$assignment->classroom->is_user()) return View::make('unauthorized', 401);

		$data = array(
			"assignment" => $assignment
		);

		if (Request::ajax()) return View::make('ajax', $data)->nest('content', 'assignment.show', $data);
		return View::make('template', $data)
				->nest('breadcrumbs', 'breadcrumbs', array("end" => Assignment::findOrFail($id)))
				->nest('content', 'assignment.show', $data);
	}
	


	public function create($classroom_id) {
		$classroom = Classroom::findOrFail($classroom_id);

		$data = array(
			"classroom" => $classroom
		);

		if ($classroom->is_admin()) {
			if (Request::ajax()) return View::make('ajax', $data)->nest('content', 'assignment.create', $data);
			return View::make('template', $data)->nest('content', 'assignment.create', $data);
		}
	}



	public function store($classroom_id) {

		$classroom = Classroom::findOrFail($classroom_id);
		if (!$classroom->is_admin()) return View::make('unauthorized', 401);

		// $type = Request::input("type");
		
		$validator = Validator::make(
			Request::all(),
			Assignment::$rules	
		);

		if ($validator->fails())
		{
			return Response::json(array(
				"status" 	=> "fail",
				"data" 		=> array(
					"validation" 	=> $validator->messages()
				)
			));

		} else {

			$emails = array();
			$classroom = Classroom::findOrFail(Request::input('classroom_id'));
			foreach ($classroom->users as $u) {
				$emails[] = $u->email;
			}
			
			$due_exploded = explode("-", Request::input('due_date'));			
			$due_time_exploded = explode(":", str_replace(" ", ":", Request::input('due_time')));

			$due_hour = $due_time_exploded[0];
			$due_mins = $due_time_exploded[1];
			if ($due_time_exploded[2] == "PM") $due_hour += 12;
			
			$submissions = 0;
			if (Request::input('has_submissions')) $submissions = 1;

			$assignment = new Assignment;
			$assignment->name = 				Request::input('name');
			$assignment->content = 				Request::input('content');
			$assignment->has_submissions = 		$submissions;
			$assignment->due = 					Carbon::create($due_exploded[2], $due_exploded[0], $due_exploded[1], $due_hour, $due_mins);
			$assignment->classroom_id = 		Request::input('classroom_id');
			$assignment->owner_id = 			Auth::user()->id;

			

			if ($assignment->save()) {
				
				if ( Request::input('alert') ) {
					Mail::send('emails/assignments/new', array("assignment" => $assignment, "emails" => $emails), function($message) use($classroom, $emails, $assignment) {
						$message
							->to($emails)
							->subject('Ringmaster - New Assignment: '.$assignment->name.' - '.$classroom->name)
							->from(Config::get('ringmaster.alert_email'), Config::get('ringmaster.alert_name'));
					});
				}

				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> [
						"refresh" => true
					]
				));
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "new-assignment-save"
				), 400);
			}
		}
		
	}


	public function edit($classroom_id, $assignment_id) {

		$assignment = Assignment::findOrFail($assignment_id);
		if ($classroom_id != $assignment->classroom->id) {
			return View::make('unauthorized', 401);
		}
		if ($assignment->classroom->is_admin()) {
			$data = [
				"assignment" => $assignment,
				"classroom" => $assignment->classroom
			];
			if (Request::ajax()) return View::make('ajax', $data)->nest('content', 'assignment.edit', $data);
			return View::make('template', $data)->nest('content', 'assignment.edit', $data);
		}
	}


	public function update($classroom_id, $assignment_id) {

		$assignment = Assignment::findOrFail($assignment_id);
		$classroom = $assignment->classroom;
		if ($classroom_id != $assignment->classroom->id) {
			return View::make('unauthorized', 401);
		}
		
		
		$validator = Validator::make(
			Request::all(),
			Assignment::$rules	
		);

		if ($validator->fails())
		{
			return Response::json(array(
				"status" 	=> "fail",
				"data" 		=> array(
					"validation" 	=> $validator->messages()
				)
			));

		} else {


			$emails = array();
			foreach ($assignment->classroom->users as $u) {
				$emails[] = $u->email;
			}
			
			$due_exploded = explode("-", Request::input('due_date'));			
			$due_time_exploded = explode(":", str_replace(" ", ":", Request::input('due_time')));

			$due_hour = $due_time_exploded[0];
			$due_mins = $due_time_exploded[1];
			if ($due_time_exploded[2] == "PM") $due_hour += 12;
			
			$submissions = 0;
			if (Request::input('has_submissions')) $submissions = 1;

			$assignment->name = 				Request::input('name');
			$assignment->content = 				Request::input('content');
			$assignment->has_submissions = 		$submissions;
			$assignment->due = 					Carbon::create($due_exploded[2], $due_exploded[0], $due_exploded[1], $due_hour, $due_mins);
						

			if ($assignment->save()) {
				
				if ( Request::input('alert') ) {
					Mail::send('emails/assignments/changed', array("assignment" => $assignment, "emails" => $emails), function($message) use($classroom, $emails, $assignment) {
						$message
							->to($emails)
							->subject('Ringmaster - Assignment Modified: '.$assignment->name.' - '.$classroom->name)
							->from(Config::get('ringmaster.alert_email'), Config::get('ringmaster.alert_name'));
					});
				}

				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> [
						"refresh" => true
					]
				));
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "assignment-update-save"
				), 400);
			}
		}
	}




    public function weight($classroom_id) {

    	$classroom = Classroom::findOrFail($classroom_id);
		if (!$classroom->is_admin()) return View::make('unauthorized', 401);


    	foreach (Request::input("weights") as $weight) {

	    	if (!$weight["assignment_id"]) {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "assignment-weight-id"
				), 400);
			}

			$assignment = Assignment::findOrFail($weight["assignment_id"]);

			if (!$assignment) {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "assignment-weight-assignment-not-found"
				), 404);
			}

			if (!$assignment->classroom->is_admin()) {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "assignment-weight-unauthorized"
				), 401);
			}

			
			$assignment->weight = $weight["new_value"];

			if ($assignment->save()) {
				// do nothing. we are in a loop. if we return here, only the first loop will save
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "assignment-weight-save"
				), 400);
			}
		}

		return Response::json(array(
			"status" 	=> "success",
			"data" 		=> null
		));

    }



    public function destroy($classroom_id, $assignment_id) {
    	$assignment = Assignment::findOrFail($assignment_id);
    	
    	if ($assignment->classroom->id != $classroom_id) {
    		 return View::make('unauthorized');
    	}
    	if (!$assignment->classroom->is_admin()) {
    		 return View::make('unauthorized');
    	}

    	if ($assignment->delete()) {
    		return Response::json(array(
    			"status" 	=> "success",
    			"data" 		=> [
    				"refresh" => true
    			]
    		));
    	}
    	
    }


}
