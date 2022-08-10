<?php
namespace App\Models;

use Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;


class CodePiece extends Eloquent {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'course_code_pieces';

    public static $rules = array();


}