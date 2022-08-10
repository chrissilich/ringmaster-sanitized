<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Carbon;

use App\Models\Classroom;
use App\Models\CodePiece;
use App\Models\User;
use App\Models\Upload;

use Auth, View, Request, Redirect, Validator,  Response;

class ClassroomController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('god', array('only' => array(
			'all',
			'gather'
		)));
		$this->middleware('csrf', array('only' => array(
			'store'
		)));
	}


	public function index()
	{
		return View::make('template')->nest('content', 'class.index');
	}


	public function all()
	{
		$classes = Classroom::orderBy('start_date', "desc")->get();
		return View::make('template')->nest('content', 'class.all', ["classes" => $classes]);
	}

	



	public function create() {
		if (Request::ajax()) return View::make('ajax')->nest('content', 'class.create');
		return View::make('template')->nest('content', 'class.create');
	}






	public function store() {

		$validator = Validator::make(
			Request::all(),
			Classroom::$rules
		);

		if ($validator->fails())
		{
			return Response::json(array(
				"status" 	=> "fail",
				"data" 		=> array(
					"validation" 	=> $validator->messages()
				)
			));
			
			//return Redirect::action('ClassroomController@create')
			//	->withErrors($validator)
			//	->withInput(Request::all());

		} else {
			
			$start_exploded = explode("-", Request::input('start_date'));
			$end_exploded = explode("-", Request::input('end_date'));

			$classroom = new Classroom;
			$classroom->name = 			Request::input('name');
			$classroom->code = 			Request::input('code');
			$classroom->description = 	Request::input('description');
			$classroom->start_date = 	Carbon::createFromDate($start_exploded[2], $start_exploded[0], $start_exploded[1]);
			$classroom->end_date = 		Carbon::createFromDate($end_exploded[2], $end_exploded[0], $end_exploded[1]);
			
			
			if ($classroom->save()) {

				// and attach this user to this classroom as the creator
				$classroom->users()->attach(Auth::user(), array('role' => 'creator'));

				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> array(
						"redirect" => action('ClassroomController@show', $classroom->id)
					)

				));
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "new-classroom-save"
				), 400);
			}

		}
		
	}



	public function upload_detach($id, $uid) {

		$classroom = Classroom::find($id);
		if ($classroom->is_admin())	{
			$uploads = $classroom->uploads()->get();
			foreach ($uploads as $upload) {
				if ($upload->id == $uid) {
					Upload::destroy($uid);
					return Response::json(array(
						"status" 	=> "success",
						"data" 		=> array(
							"refresh" => true
						)
					));
				}
			}
			return Response::json(array(
				"status" 	=> "error",
				"message" 	=> "classroom-upload-delete-not-found"
			), 404);
		} else {
			return Response::json(array(
				"status" 	=> "error",
				"message" 	=> "classroom-upload-delete-unauthorized"
			), 401);
		}
	}




	public function generate_code($id) {
		
		$code = false;
		while (!$code) {
			$code = $this->generate_one_code();
		}

		$classroom = Classroom::findOrFail($id);
		$classroom->join_code = $code;

		if ($classroom->save()) {
			return Response::json(array(
				"status" 	=> "success",
				"message" 	=> $code
			));
		} else {
			return Response::json(array(
				"status" 	=> "error",
				"message" 	=> "classroom-join-code-save"
			), 400);
		}
	}

	private function generate_one_code() {
		$pieces = CodePiece::all();

		$r1 = rand(0, count($pieces)-1);
		$r2 = rand(0, count($pieces)-1);

		if ($r1 == $r2) return false; // can't use a code with the same word twice
		
		$code = $pieces[$r1]->content . " " . $pieces[$r2]->content;

		$collision = Classroom::where('join_code', '=', $code)->get();
		if (count($collision)) {
			return false; // this code has already been used.
		}

		return $code;
	}



	public function show($id) {
		$data = array(
			"class" => Classroom::findOrFail($id),
			"classroom" => Classroom::findOrFail($id),
			"me" 	=> Auth::user()
		);

		return View::make('template', $data)
				->nest('breadcrumbs', 'breadcrumbs', array("end" => Classroom::findOrFail($id)))
				->nest('content', 'class.show', $data);
	}


	public function edit($id) {
		$data = array(
			"classroom" => Classroom::findOrFail($id)
		);
		
		if (Request::ajax()) return View::make('ajax')->nest('content', 'class.edit', $data);

		return View::make('template', $data)
				->nest('breadcrumbs', 'breadcrumbs', array("end" => Classroom::findOrFail($id)))
				->nest('content', 'class.edit', $data);
	}



	

	public function update($id) {
		$classroom = Classroom::findOrFail($id);

		if (!$classroom->is_admin()) {
			return Response::json(array(
				"status" 	=> "error",
				"message" 	=> "classroom-update-unauthorized"
			), 401);
		}
			
		$validator = Validator::make(
			Request::all(),
			Classroom::$rules
		);

		if ($validator->fails())
		{
			return Response::json(array(
				"status" 	=> "fail",
				"data" 		=> array(
					"validation" 	=> $validator->messages()
				)
			), 400);
			
			//return Redirect::action('ClassroomController@create')
			//	->withErrors($validator)
			//	->withInput(Request::all());

		} else {
			
			$start_exploded = explode("-", Request::input('start_date'));
			$end_exploded = explode("-", Request::input('end_date'));

			$classroom->name = 			Request::input('name');
			$classroom->code = 			Request::input('code');
			$classroom->description = 	Request::input('description');
			$classroom->start_date = 	Carbon::createFromDate($start_exploded[2], $start_exploded[0], $start_exploded[1]);
			$classroom->end_date = 		Carbon::createFromDate($end_exploded[2], $end_exploded[0], $end_exploded[1]);
			
			
			if ($classroom->save()) {

				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> array(
						"redirect" => action('ClassroomController@show', $classroom->id)
					)
				));
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "classroom-update-save"
				), 400);
			}
		}
	}


	public function join() {
		if (Request::ajax()) return View::make('ajax')->nest('content', 'class.join');
		return View::make('template')->nest('content', 'class.join');
	}

	

	public function storejoin() 
	{
		$code = trim(Request::input("join_code"));
		$classroom = Classroom::where("join_code", "=", $code)->first();

		if (!$classroom) {
			if (Request::ajax()) {
				return Response::json(array(
					"status" 	=> "error",
					"message" => "Class not found.",
					"code" 	=> "classroom-join-class-not-found"
				), 404);
			} else {
				return Redirect::back()->withErrors(array(
					"join_code" => "Invalid Code"
				), 400);
			}
		}

		foreach ($classroom->allUsers as $u) {
			if ($u->id == Auth::user()->id) {
				$msg = "You're already in that class.";
				
				if ($u->pivot->role == "banned") {
					$msg = "You used to be in this class, but got kicked out. You can't rejoin.";
				}
				
				if (Request::ajax()) {
					return Response::json(array(
						"status" 	=> "fail",
						"data" => array(
							"validation" => array(
								"join_code" => [$msg]
							)
						)
					), 400);
				} else {
					return Redirect::action('ClassroomController@show', $classroom->id);
				}
			}
		}		
		
		$classroom->users()->attach(Auth::user(), array('role' => 'member'));

		if (Request::ajax()) {
			return Response::json(array(
				"status" 	=> "success",
				"data" 		=> array(
					"redirect" => action('ClassroomController@show', $classroom->id)
				)
			));
		} else {
			return Redirect::back('ClassroomController@show', $classroom->id);
		}
	}



	public function role($id, $user, $role) {
		$classroom = Classroom::findOrFail($id);
		if (!$classroom->is_admin()) {
			return Response::json(array(
				"status" 	=> "fail",
				"data" => array(
					"message" => "You're not allowed to do that."
				)
			), 401);
		}
		$user = User::findOrFail($user);

		// find existing relationship
		foreach ($classroom->users as $u) {
			if ($u->id == $user->id) {

				if ($u->pivot->role == "creator") {
					// cant demote a creator
					return Response::json(array(
						"status" 	=> "fail",
						"data" => array(
							"message" => "Class creators can't be demoted."
						)
					), 400);
				}
			}	
		}

		if ($role == "none") {
			$classroom->users()->detach($user);

			return Response::json(array(
				"status" 	=> "success",
				"data" 		=> array(
					"refresh" => true
				)
			));
		}

		if ($role != "member" && 
			$role != "banned" && 
			$role != "admin" ) {

			return Response::json(array(
				"status" 	=> "fail",
				"data" => array(
					"message" => "Not a valid role."
				)
			), 400);
		}

		$classroom->users()->detach($user);
		$classroom->users()->attach($user, array('role' => $role));

		return Response::json(array(
			"status" 	=> "success",
			"data" 		=> array(
				"refresh" => true
			)
		));
	}


	public function leave($id) 
	{
		Auth::user()->classrooms()->detach( $id );
		
		return Redirect::action('ClassroomController@show', $id);
	}





	public function gather($id) {
		$classroom = Classroom::findOrFail($id);

		// make the gathers folder if needed
		$path = Config::get('ringmaster.uploads_path').'/gathers/';
		if(!File::exists($path)) File::makeDirectory($path, 0755);

		echo "<pre>";

		function strip_special_chars($z){
		    $z = strtolower($z);
		    $z = preg_replace('/[^a-z0-9 -]+/', '', $z);
		    $z = str_replace(' ', '-', $z);
		    return trim($z, '-');
		}


		// make a folder for this class if needed
		$className = strip_special_chars($classroom->name);
		$pathToClass = Config::get('ringmaster.uploads_path').'/gathers/'.$classroom->id.'-'.$className;
		// echo $pathToClass; die;
		if(!File::exists($pathToClass)) File::makeDirectory($pathToClass, 0755);
	


		
		$submittingUsers = array();
		foreach ($classroom->assignments as $i => $a) {
			// echo $i . "-" . strip_special_chars($a->name) . "<br>";


			$assignmentName = strip_special_chars($a->name);
			$pathToAssignment = $pathToClass.'/'.$i."-".$assignmentName;
			// echo $pathToAssignment . "<br>"; 
			if(!File::exists($pathToAssignment)) File::makeDirectory($pathToAssignment, 0755);

			// // loop to get all submitting users
			foreach ($a->assignmentSubmissions as $j => $as) {
				
				$username = strip_special_chars($as->owner->prettyName());
				// echo $username . " " ;
				// echo "<br>";
				if (!array_key_exists($as->owner->id, $submittingUsers)) {
					$submittingUsers[ $as->owner->id ] = array();
				}
				$submittingUsers[ $as->owner->id ]["username"] = $username;
				$submittingUsers[ $as->owner->id ]["submissions"] = array();
				array_push( $submittingUsers[ $as->owner->id ]["submissions"], $as);
					
				$pathToAssignmentAndSubmitter = $pathToAssignment.'/'.$as->owner->id.'-'.$username;
				// echo $path; die;
				if(!File::exists($pathToAssignmentAndSubmitter)) File::makeDirectory($pathToAssignmentAndSubmitter, 0755);
				// echo $pathToAssignmentAndSubmitter;
				// die;
				$pathToAssignmentAndSubmitterAndSubmission = $pathToAssignmentAndSubmitter . "/" . $as->id;
				$pathToAssignmentAndSubmitterAndSubmission .= "--" . Carbon::parse($as->updated_at)->format("Y-m-d--H-i-s");
				// echo "move to: " .$pathToAssignmentAndSubmitterAndSubmission;
				if(!File::exists($pathToAssignmentAndSubmitterAndSubmission)) File::makeDirectory($pathToAssignmentAndSubmitterAndSubmission, 0755);
				echo $pathToAssignmentAndSubmitterAndSubmission;
				// die;

				foreach ($as->uploads as $k => $up) {
					echo "<br> from: uploads or whatever/" . $up->new_filename;

					$oldfile = Config::get('ringmaster.uploads_path')."/".$up->new_filename;
					$newfile = $pathToAssignmentAndSubmitterAndSubmission.'/'.$up->new_filename;
					if(File::exists($oldfile) && !File::exists($newfile)) {
						File::copy($oldfile, $newfile);
					} else {
						echo "<br>couldnt find old file or new file already exists";
					}
				}

				if ($as->content) {
					File::put($pathToAssignmentAndSubmitterAndSubmission.'/'.$j.'-text-submission.txt',$as->content);
				}

				echo "<br>";
				echo "<br>";
								
			}


		}


	}


}
