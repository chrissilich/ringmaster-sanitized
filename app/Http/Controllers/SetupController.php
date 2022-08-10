<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Auth, View, Request, Redirect, Validator,  Response, Mail, Config;


class SetupController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
	{
		return Redirect::action("SetupController@name");
	}



	public function name()
	{
		if (Auth::user()->name) return Redirect::action("SetupController@classes");
		return View::make('template')->nest('content', 'setup.name');
	}





	public function doName() 
	{
		$validator = Validator::make(
			Request::all(),
			array(
				'fname' => 'required',
				'lname' => 'required'
			)
		);

		if ($validator->fails())
		{
			// get the error messages from the validator
			$messages = $validator->messages();

			// redirect our user back to the form with the errors from the validator
			return Redirect::action('SetupController@name')
				->withErrors($validator)
				->withInput(Request::all());

		} else {
			
			$user = Auth::user();
			$user->name = Request::input('fname') . " " . Request::input('lname');

			// save our $user
			$user->save();

			return Redirect::action('SetupController@classes');

		}
		
	}





	public function classes()
	{
		if (count(Auth::user()->classrooms)) {
			Auth::user()->initial_setup_completed = true;
			Auth::user()->save();
			return Redirect::action("HomeController@index");
		}

		return View::make('template')->nest('content', 'setup.classes');
	}


	public function doClasses() 
	{
		
		
		
		return Redirect::action('SetupController@done');

	}



	public function done()
	{
		Auth::user()->initial_setup_completed = true;
		Auth::user()->save();
		return View::make('template')->nest('content', 'setup.done');
	}


}
