<?php
namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;


class Grade extends Eloquent {

    use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'grades';

    public static $rules = array(
		
	);


    public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function assignment()
	{
		return $this->belongsTo('App\Models\Assignment');
	}
	

}