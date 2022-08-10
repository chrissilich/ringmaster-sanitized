<?php
namespace App\Models;

use Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;


class Upload extends Eloquent {

    use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'uploads';

	public static $rules = array(
		'file' => 'required',
		//'size' => 20480, // 20mb
		'belongs_to_id' => 'required|numeric',
		'belongs_to_type' => 'required',
		'upload_kind' => 'required'
	);

    public function owner() {
		return $this->belongsTo('App\Models\User', 'owner_id');
	}

}