<?php
namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;


class AssignmentSubmission extends Eloquent {

    use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'assignment_submissions';

    public static $rules = array(
		// 'content' => 'required',
	);

    public function scopeOfAssignment($query, $assignmentID) {
    	return $query->where('assignment_id', '=', $assignmentID);
    }

    public function scopeOfOwner($query, $ownerID) {
    	return $query->where('owner_id', '=', $ownerID);
    }

    public function owner()
	{
		return $this->belongsTo('App\Models\User', 'owner_id');
	}

	public function assignment()
	{
		return $this->belongsTo('App\Models\Assignment');
	}

	public function uploads()
	{
		return $this->hasMany('App\Models\Upload', "belongs_to_id")->where('belongs_to_type', '=', 'assignment_submission');
	}

}