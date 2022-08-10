<?php
namespace App\Models;

use Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;


class Extra extends Eloquent {

    use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'extras';

}