<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;


use Eloquent;

class User extends Eloquent implements AuthenticatableContract,
										AuthorizableContract,
										CanResetPasswordContract
										 {


	use SoftDeletes, Authenticatable, Authorizable, CanResetPassword, Notifiable;

	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';


	public static $creation_rules = array(
		'email' 	=> 'required|email|unique:users',
		'password' 	=> 'required|min:8|same:password2'
	);

	public static $creation_error_messages = array(
		'unique' 	=> 'The :attribute has already been taken. Or you clicked the submit button twice, so you registered twice. If that\'s the case, go check your email, and stop double-clicking things on the internet.'
	);

	public static $reset_password_rules = array(
		'email' 		=> 'required|email|exists:users',
		'password' 		=> 'required|min:8|same:password2'
	);

	/*
	// created in user controller because this one has more logic to it.
	public static $edit_rules = array(
		'name' 			=> 'required',
		'oldpassword' 	=> 'required|old_password_match',
		'password' 		=> 'required|min:8|same:password2'
	);
	*/



	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	public function god() 
	{
		if ($this->email == "chris.silich@gmail.com") return true;
		return false;
	}


	public function prettyName() 
	{
		if ($this->name) return $this->name;
		return explode("@", $this->email)[0];
	}

	public function classrooms()
	{
		return $this
			->belongsToMany('App\Models\Classroom')
			->where("role", "!=", "banned")
			->withPivot("role")
			->orderBy("start_date", 'desc');
	}


	public function assignmentSubmissions()
	{
		return $this->hasMany('App\Models\AssignmentSubmission', 'owner_id');
	}
}
