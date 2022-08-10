<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Upload;

use Auth, View, Redirect, Request, Validator, Response, Mail, Config, File;


class UploadController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }


	public function create() {
		return View::make('unauthorized');
	}

	public function destroy($id) {
		$upload = Upload::find($id);
		
		if ($upload && $upload->owner->id === Auth::user()->id) {

			// and attach this user to this classroom as the creator
			$upload->delete();

			return Response::json(array(
				"status" 	=> "success",
				"data" 		=> array(
					"refresh" => true
				)

			));
		} else if ($upload) { // owner didnt match
			return Response::json(array(
				"status" 	=> "error",
				"message" 	=> "upload-delete-unauthorized"
			), 401);

		} else {
			return Response::json(array(
				"status" 	=> "error",
				"message" 	=> "upload-delete-unauthorized"
			), 404);
		}
	}



	public function store() {
 
		$validator = Validator::make(
			Request::all(),
			Upload::$rules
		);

		// dd(Request::file('file'));

		$current_timestamp = time();

		// dd(Config::get('ringmaster.uploads_path'));

		if ($validator->fails())
		{
			// get the error messages from the validator
			$messages = $validator->messages();

			// redirect our user back to the form with the errors from the validator
			return Redirect::back() // can come from a department, event, or classroom's show page
				->withErrors($validator)
				->withInput(Request::all());

		} elseif (Request::file('file')->move(Config::get('ringmaster.uploads_path'), $current_timestamp."_".Request::file('file')->getClientOriginalName())) {

			$upload = new Upload;
			$upload->filename = $current_timestamp."_".Request::file('file')->getClientOriginalName(); // .Request::file('file')->getClientOriginalExtension();
			
			if (Request::input("name")) {
				$upload->name = Request::input("name"); 
			} else {
				$upload->name = Request::file('file')->getClientOriginalName();
			}

			$upload->belongs_to_id = Request::input("belongs_to_id");
			$upload->belongs_to_type = Request::input("belongs_to_type");
			$upload->upload_kind = Request::input("upload_kind");

			$upload->owner_id = Auth::user()->id;

			if ($upload->save()) {

				if (Request::input("upload_replace")) {
					// try to find old upload in that matches this use case, and delete it.
					$old = Upload::where("belongs_to_id", Request::input("belongs_to_id"))
						->where("belongs_to_type", Request::input("belongs_to_type"))
						->where("upload_kind", Request::input("upload_kind"))
						->get();
					
					//if ($old) return $old;
					foreach ($old as $o) {
						if ($o->id != $upload->id) {
							File::delete(Config::get('ringmaster.uploads_path')."/".$o->filename);
							$o->delete();
						}
					}
				}

				return Redirect::back()
					->with("message", "Your file was uploaded: " . Request::file('file')->getClientOriginalName());

			} else {
				return "Something went wrong. Error code: 'new-upload-save'.";
			}

			

		} else {

			return "Something went wrong. Error code: 'new-upload-move'.";
		}

	}




}
