<?php
namespace App\Models;



use Carbon, Eloquent, Auth;
use Illuminate\Database\Eloquent\SoftDeletes;



class Classroom extends Eloquent {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'classrooms';

	public static $rules = array(
		'name' => 'required',
		// 'code' => 'required',
		'start_date' => 'required',
		'end_date' => 'required'
	);


	public function is_user() { // for checking if the user has a role in this class, and that role isn't banned 
		if (Auth::user() && Auth::user()->id == 1) return true;
		foreach(Auth::user()->classrooms as $c) {
			if ($c->id == $this->id && $c->pivot->role && $c->pivot->role != "banned") return true;
		}
	}

	public function is_member() { // for checking if the user is specifically a member, not an admin
		foreach(Auth::user()->classrooms as $c) {
			if ($c->id == $this->id && $c->pivot->role == "member") return true;
		}
	}

	public function is_banned() { // for checking if the user is specifically a member, not an admin
		foreach(Auth::user()->classrooms as $c) {
			if ($c->id == $this->id && $c->pivot->role == "banned") return true;
		}
	}

	public function is_admin() { // for checking if the user is specifically an admin or creator
		if (Auth::user() && Auth::user()->id == 1) return true;
		foreach(Auth::user()->classrooms as $c) {
			if ($c->id == $this->id) {
				if ($c->pivot->role == "creator" || $c->pivot->role == "admin") return true;
			} 
		}
		return false;;
	}

	public function is_creator() { // for checking if the user is specifically the creator of the class
		foreach(Auth::user()->classrooms as $c) {
			if ($c->id == $this->id && $c->pivot->role == "creator") return true;
		}
	}

	public function creators()
	{
		return $this->belongsToMany('App\Models\User')->withPivot("role")->where('role', '=', 'creator');
	}
	public function admins()
	{
		return $this->belongsToMany('App\Models\User')->withPivot("role")->where('role', '=', 'creator')->orWhere('role', '=', 'admin');
	}
	public function members()
	{
		return $this->belongsToMany('App\Models\User')->withPivot("role")->where('role', '=', 'creator');
	}
	public function users()
	{	
		return $this->belongsToMany('App\Models\User')->withPivot("role")->where('role', '!=', 'banned');
	}
	public function allUsers()
	{	
		return $this->belongsToMany('App\Models\User')->withPivot("role");
	}


	public function posts()
	{
		return $this->hasMany('App\Models\Post', 'belongs_to_id')->where('belongs_to_type', '=', 'classroom')->orderBy('created_at', 'ASC');
	}

	public function recentPosts()
	{
		return $this->hasMany('App\Models\Post', 'belongs_to_id')->where('belongs_to_type', '=', 'classroom')->where('created_at', '>', Carbon::now()->subWeek())->orderBy('created_at', 'ASC');
	}

	public function assignments()
	{
		return $this->hasMany('App\Models\Assignment', 'classroom_id')->orderBy('due', 'DESC');
	}

	public function futureAssignments()
	{
		return $this->hasMany('App\Models\Assignment', 'classroom_id')
			->where('due', '>', Carbon::now()->addHours(-1))
			->orderBy('due', 'ASC');
	}

	public function events()
	{
		return $this
			->hasMany('App\Models\CalendarEvent', 'belongs_to_id')
			->orderBy('start', 'DESC')
			->where('belongs_to_type', '=', 'classroom');
	}

	public function pastEvents()
	{
		return $this
			->hasMany('App\Models\CalendarEvent', 'belongs_to_id')
			->orderBy('start', 'DESC')
			->where('belongs_to_type', '=', 'classroom')
			->where('start', '<', Carbon::now()->addHour())
			->orderBy('created_at', 'ASC');
	}

	public function futureEvents()
	{
		return $this
			->hasMany('App\Models\CalendarEvent', 'belongs_to_id')
			->orderBy('start', 'DESC')
			->where('belongs_to_type', '=', 'classroom')
			->where('start', '>', Carbon::now()->subHour())
			->orderBy('created_at', 'ASC');
	}

	public function uploads()
	{
		return $this->hasMany('App\Models\Upload', "belongs_to_id")->where('belongs_to_type', '=', 'classroom')->where('upload_kind', '=', 'classroom_info');
	}

	public function headerImage()
	{
	    return $this->hasOne('App\Models\Upload', "belongs_to_id", "id")
	        ->where('belongs_to_type', '=', 'classroom')
	        ->where('upload_kind', '=', 'classroom_header')
	        ->orderBy('created_at', 'DESC');
	}
}