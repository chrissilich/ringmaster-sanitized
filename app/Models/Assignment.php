<?php
namespace App\Models;

use Eloquent, Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Eloquent {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'assignments';

    public static $rules = array(
		'name' => 'required',
		//'content' => 'required',
		'due_time' => 'required',
		'due_date' => 'required|date_format:m-d-Y',
		//'classroom_id' => 'required'
	);


    public function owner()
	{
		return $this->belongsTo('App\Models\User', 'owner_id');
	}

	public function classroom()
	{
		return $this->belongsTo('App\Models\Classroom');
	}

	public function uploads()
	{
		return $this->hasMany('App\Models\Upload', "belongs_to_id")->where('belongs_to_type', '=', 'assignment');
	}

	public function assignmentSubmissions()
	{
		return $this->hasMany('App\Models\AssignmentSubmission');//->where('belongs_to_type', '=', 'assignment');
	}

	public function myAssignmentSubmissions()
	{
		return $this->hasMany('App\Models\AssignmentSubmission')->where('owner_id', '=', Auth::user()->id);
	}

}