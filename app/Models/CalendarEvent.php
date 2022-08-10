<?php
namespace App\Models;

use Eloquent;


use Illuminate\Database\Eloquent\SoftDeletes;


class CalendarEvent extends Eloquent {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'events';

	public static $rules = array(
		'name' => 'required',
		// 'content' => 'required',
		'start_date' => 'required',
		'end_date' => 'required',
		'start_time' => 'required',
		'end_time' => 'required',
		'belongs_to_type' => 'required',
		'belongs_to_id' => 'required|numeric'
	);


	public function owner()
	{
		return $this->belongsTo('App\Models\User', 'owner_id');
	}

	public function posts()
	{
		return $this
			->hasMany('App\Models\Post', 'belongs_to_id')
			->where('belongs_to_type', '=', 'event')
			->orderBy('created_at', 'DESC');
	}

	public function classroom()
	{
		if ($this->belongs_to_type == "classroom") {
			return $this
				->belongsTo('App\Models\Classroom', "belongs_to_id", "id");
		}
	}

	public function uploads()
	{
		return $this
			->hasMany('App\Models\Upload', "belongs_to_id")
			->where('belongs_to_type', '=', 'event');
	}

}