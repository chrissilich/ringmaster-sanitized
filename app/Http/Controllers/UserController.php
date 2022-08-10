<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;

use Auth, View, Request, Redirect, Validator,  Response, Mail, Config, Hash;

class UserController extends Controller {

	public function __construct()
	{
		$this->middleware('auth', array('only' => array(
			'index', 
			'show'
		)));

		$this->middleware('god', array('only' => array(
			'index'
		)));

		$this->middleware('auth-pre-validation', array('only' => array(
			'notValidated',
			//'validate', // now unauthenticated users can login and validate in one step
			'requestNewValidationToken'
		)));

		$this->middleware('guest', array('only' => array(
			'login', 
			'doLogin', 
			'create', 
			'store',
			'forgot',
			'forgotSend',
			'forgotToken',
			'forgotValidate',
			'forgotBadCode'
		)));

		$this->middleware('csrf', array('only' => array(
			'doLogin',
			'store'
		)));
	}






	public function index()
	{		
		$data = array(
			"users" => User::all()
		);
		return View::make('template')->nest('content', 'user/list', $data);
	}

	public function show($id)
	{
		if (Auth::user()->id == $id || Auth::user()->god()) {
			$data = array(
				"user" => User::findOrFail($id)
			);
			return View::make('template')->nest('content', 'user/show', $data);
		} else {
			return "unauthorized";
		}
	}


	public function login()
	{
		return View::make('template', ["hide_login" => true])->nest('content', 'user/login');
	}

	public function doLogin() {
		
		Auth::attempt(array(
			'email' => 		Request::input('email'), 
			'password' => 	Request::input('password')
		), true);
		
		if (Auth::user() && Auth::user()->initial_setup_completed) {
			return Redirect::action('HomeController@index');
		} else if (Auth::user()) {
			return Redirect::action('SetupController@index');
		} else {
			return Redirect::action('UserController@login')->with('message', 'Email and password do not match.')->withInput();
		}
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::action('HomeController@index');
	}


	public function forgot() 
	{
		return View::make('template')->nest('content', 'user/forgot');
	}

	public function forgotSend() 
	{
		$user = User::where('email', Request::input("email"))->first();

		if (!$user) {
			return "User not found";
		}

		$user->forgot_token = Str::random(40);

		// save our $user
		if ($user->save()) {

			// send em their validation email
			Mail::send('emails/user/forgot', array("user" => $user), function($message) {
				$message->to(Request::input('email'))
						->subject('Ringmaster Forgot Password');
						//->from("chris.silich@gmail.com", "Ringmaster");
			});

			// show that they've registered.
			return View::make('template')->nest('content', 'user/forgot_sent')->with("email", Request::input('email'));
		} else {
			return "Something went wrong. Error code: 'forgot-user-save'.";
		}

	}

	public function forgotToken($forgot_token) 
	{
		return View::make('template')->nest('content', 'user/forgot_token', ['forgot_token' => $forgot_token]);
	}

	public function forgotBadCode() 
	{
		return View::make('template')->nest('content', 'user/forgot_bad_code', []);
	}

	public function forgotValidate($forgot_token) 
	{

		$validator = Validator::make(
			Request::all(),
			User::$reset_password_rules
		);

		if ($validator->fails())
		{
			// get the error messages from the validator
			$messages = $validator->messages();

			// redirect our user back to the form with the errors from the validator
			return Redirect::action('UserController@forgotValidate', $forgot_token)
				->withErrors($validator)
				->withInput(Request::all());

		} else {

			$user = User::where('email', "=", Request::input("email"))
						->whereNotNull('forgot_token')
						->where('forgot_token', "=", Request::input("forgot_token"))
						->first();

			//dd($user);

			if (!$user) {
				return Redirect::action('UserController@forgotBadCode');
			}

			$user->password = Hash::make(Request::input('password'));
			$user->forgot_token = null;

			if ($user->save()) {

				Auth::attempt(array(
					'email' => 		Request::input('email'), 
					'password' => 	Request::input('password')
				), true);

				return Redirect::action('HomeController@index');

			} else {
				return "Something went wrong. Error code: 'password-reset-save'.";
			}
		}
	}


	public function create() {

		return View::make('template')->nest('content', 'user/create');

	}

	public function store() {
		$validator = Validator::make(
			Request::all(),
			User::$creation_rules,
			User::$creation_error_messages
		);

		if ($validator->fails())
		{

			// get the error messages from the validator
			$messages = $validator->messages();

			// redirect our user back to the form with the errors from the validator
			return Redirect::action('UserController@create')
				->withErrors($validator)
				->withInput(Request::all());

		} else {
			
			$user = new User;
			$user->email = Request::input('email');
			$user->password = Hash::make(Request::input('password'));
			$user->validation_token = Str::random(40);
			
			// save our $user
			if ($user->save()) {
				
				// log them in
				Auth::attempt(array(
					'email' => 		$user->email, 
					'password' => 	Request::input('password')
				), true);
				
				
				// send em their validation email
				Mail::send('emails/user/validation', array("user" => Auth::user()), function($message) use ($user) {
					$message->to(Auth::user()->email)->subject('Ringmaster Registration - Validate your email address.');
				});
				

				// show that they've registered.
				return View::make('template')->nest('content', 'user/registered');
			} else {
				return "Something went wrong. Error code: 'new-user-save'.";
			}
		}
		
	}

	public function edit($id) {
		if (Auth::user()->id == $id || Auth::user()->god()) {
			$data = array(
				"user" => User::findOrFail($id)
			);
			return View::make('template')->nest('content', 'user/edit', $data);
		} else {
			return "unauthorized";
		}
	}





	public function update($id) {
		if (!Auth::user()->id == $id && !Auth::user()->god()) 
		{
			return "unauthorized";
		}

		$user = User::findOrFail($id);		

		Validator::extend('old_password_match', function($attribute, $value, $parameters) use ($user)
		{
			return Auth::validate(["email" => $user->email, "password" => Request::input("oldpassword")]);
		});

		$rules = array(
			// 'name' 			=> 'required',
			// 'oldpassword' 	=> 'required|old_password_match',
			// 'password' 		=> 'required|min:8|same:password2'
		);

		if (Request::input("password")) {
			// user wants to change password
			$rules["oldpassword"] = 'required|old_password_match';
			$rules["password"] = 'required|min:8|same:password2';
		}

		$validator = Validator::make(
			Request::all(),
			$rules,
			[
				"old_password_match" => "You must enter your old password correctly."
			]
		);


		if ($validator->fails())
		{
			// get the error messages from the validator
			$messages = $validator->messages();

			// redirect our user back to the form with the errors from the validator
			return Redirect::action('UserController@edit', $id)
				->withErrors($validator)
				->withInput(Request::all());

		} else {
			if (Request::input("name")) $user->name = Request::input("name");
			if (Request::input("password")) $user->password = Hash::make(Request::input('password'));
			if ($user->save()) {
				return Redirect::action('UserController@show', $id);
			} else {
				return "Something went wrong. Error code: 'user-update-save'.";
			}
		}

	}



	



	public function tokenNotValidated() {
		return View::make('template')->nest('content', 'user/not_validated');
	}

	public function validatedToken() {
		return Response::json(["validated" => Auth::user()->validated]);
	}

	public function validateToken($token) {

		if (!$token) { 
			return Redirect::url("/");
		}

		//if (!Auth::user() && Request::input('email') && Request::input('password')) {
		//	// this is a user who has tried to follow a validation link, found themselves
		//	// not logged in, and attempted to login and validate in one step.
		//
		//	Auth::attempt(array(
		//		'email' => 		Request::input('email'), 
		//		'password' => 	Request::input('password')
		//	), true);
		//}


		//if (Auth::user()) {
			// user is logged in (maybe from above, maybe already), so validate them

			//$user = Auth::user();
			$user = User::where("validation_token", "=", $token)->firstOrFail();
			//if ($token == $user->validation_token) {
				$user->validation_token = null;
				$user->validated = true;
				if ($user->save()) {
					return View::make('template')->nest('content', 'user/validated');
				} else {
					return "Something went wrong. Error code: 'validate-save'.";
				}
			//} else {
			//	return View::make('template')->nest('content', 'user/validation_mismatch');
			//}

		//} else {
		//	// this is a user who has tried to follow a validation link, found themselves
		//	// not logged in, so we're showing them a login form with the validation code embedded
		//
		//	$data = [
		//		"validation_token" => $token
		//	];
		//
		//	return View::make('template', ["hide_login" => true])->nest('content', 'user/login', $data);
		//}


		
	}

	public function requestNewValidationToken() {
		//return View::make('emails/user/validation');
		
		$user = Auth::user();
		
		// this would create a new token. we'll just resend the old one
		//$user->validation_token = Str::random(40);

		//if ($user->save()) {

			Mail::send('emails/user/validation', array("user" => Auth::user()), function($message) {
				$message->to(Auth::user()->email)->subject('Ringmaster Registration - Validate your email address... again?');
			});

			return View::make('template')->nest('content', 'user/validation_resent');

		//} else {
		//	return "Something went wrong. Error code: 'resend-validation-save'.";
		//}
		
	}




	

}
