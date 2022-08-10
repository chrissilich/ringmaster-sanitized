<?php
namespace App\Models;

use Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Eloquent {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'posts';

    public static $rules = array(
        'name' => 'required',
        'content' => 'required',
        'belongs_to_id' => 'required|numeric',
        'belongs_to_type' => 'required'
    );

    public function classroom()
    {
        if ($this->belongs_to_type == "classroom") {
            return $this
                ->belongsTo('App\Models\Classroom', "belongs_to_id", "id");
        }
    }

    public function event()
    {
        if ($this->belongs_to_type == "event") {
            return $this
                ->belongsTo('App\Models\CalendarEvent', "belongs_to_id", "id");
        }
    }

    public function parentPost()
    {
        if ($this->belongs_to_type == "post") {
            return $this
                ->belongsTo('App\Models\Post', "belongs_to_id", "id");
        }
    }


    public function users() // aka, subscribers to this post
    {
        return $this->belongsToMany("App\Models\User");
    }

    


    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'belongs_to_id')->where('belongs_to_type', '=', 'post')->orderBy('created_at', 'DESC');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', "owner_id");
    }

}