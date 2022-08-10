<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Grade;

use Auth, View, Request, Validator,  Response;

class GradeController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		
        // TODO restrict creation to class admins
	}

	public function update()
	{

		foreach (Request::input("grades") as $grade) {
			if (!$grade["assignment_id"] || !$grade["user_id"]) {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "grade-ids"
				), 400);
			}

			$assignment = Assignment::findOrFail($grade["assignment_id"]);

			if (!$assignment) {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "grade-assignment-not-found"
				), 400);
			}

			if (!$assignment->classroom->is_admin()) {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "grade-unauthorized"
				), 401);
			}

			$found = Grade::where('user_id', '=', $grade["user_id"])
						  ->where('assignment_id', '=', $grade["assignment_id"])
						  ->get()
						  ->first();

			//return $grade["assignment_id"];

			if ($found) {
				$found->grade = $grade["new_value"];
				$found->comment = $grade["comment"];

				if ($found->save()) {
					// do nothing. we are in a loop. if we return here, only the first loop will save
				} else {
					return Response::json(array(
						"status" 	=> "error",
						"message" 	=> "found-grade-update-save"
					), 400);
				}

			} else {
				$new_grade = new Grade;
				$new_grade->assignment_id = $grade["assignment_id"];
				$new_grade->user_id = $grade["user_id"];
				$new_grade->owner_id = Auth::user()->id;
				$new_grade->grade = $grade["new_value"];
				$new_grade->comment = $grade["comment"];
				
				if ($new_grade->save()) {
					// do nothing. we are in a loop. if we return here, only the first loop will save
				} else {
					return Response::json(array(
						"status" 	=> "error",
						"message" 	=> "new-grade-save"
					), 400);
				}			
			}
		}

		return Response::json(array(
			"status" 	=> "success",
			"data" 		=> null
		));
	}


}
