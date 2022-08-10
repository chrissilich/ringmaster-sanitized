<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\CalendarEvent;
use App\Models\Classroom;

use Auth, View, Request, Validator,  Response, Mail, Config, Carbon;


class PostController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }


	public function index()
	{

		$data = array(
			"me" => Auth::user(),
			"posts" => Post::all()
		);

		return View::make('template', $data)->nest('content', 'post.index', $data);
	}



	public function create($belongs_to_type, $belongs_to_id) {
		$data = array(
			"id" => $belongs_to_id, 
			"type" => $belongs_to_type
		);
		if ($belongs_to_type == "classroom") {
			$data[$belongs_to_type] = Classroom::findOrFail($belongs_to_id);
		}
		if ($belongs_to_type == "event") {
			$data[$belongs_to_type] = CalendarEvent::findOrFail($belongs_to_id);
		}
		if ($belongs_to_type == "post") {
			$data[$belongs_to_type] = Post::findOrFail($belongs_to_id);
		}

		if (Request::ajax()) return View::make('ajax', $data)->nest('content', 'post.create', $data);
		return View::make('template', $data)->nest('content', 'post.create', $data);
	}




	public function store() {
		$validator = Validator::make(
			Request::all(),
			Post::$rules	
		);

		if ($validator->fails())
		{
			return Response::json(array(
				"status" 	=> "fail",
				"data" 		=> array(
					"validation" 	=> $validator->messages()
				)
			));

		} else {

			$type = Request::input('belongs_to_type');
			
			$emails = array();
			$postLocation;
			if ($type == "classroom") {
				$postLocation = Classroom::findOrFail(Request::input('belongs_to_id'));
			} elseif ($type == "event") {
				$postLocation = CalendarEvent::findOrFail(Request::input('belongs_to_id'));
			} elseif ($type == "post") {
				$postLocation = Post::findOrFail(Request::input('belongs_to_id'));
			}

			// if type is class or dept, goes to users
			// if type is event, goes to parent class or dept's users
			// if type is post, goes to subscribers

			if ($type == "classroom") {
				foreach ($postLocation->users as $u) {
					$emails[] = $u->email;
				}
			} elseif ($type == "event") {
				
				if ($postLocation->classroom()) {
					foreach ($postLocation->classroom->users as $u) {
						$emails[] = $u->email;
					}
				}
			} elseif ($type == "post") {
				// add this user to the subscriber list for this post
					// nevermind, done after we create the post
			}

			$post = new Post;
			$post->name = 				Request::input('name');
			$post->content = 			Request::input('content');
			
			$post->belongs_to_type =	Request::input('belongs_to_type');
			$post->belongs_to_id =	 	Request::input('belongs_to_id');

			$post->owner_id = Auth::user()->id;

			
			
			if ($post->save()) {

				// subscribe this poster to this post. we recursively loop through them to find 
				// who to email, so any replies will find all ancestors
				$post->users()->save(Auth::user());

				if ($post->parentPost()) {
					// this post has a parent
					$emails[] = $post->parentPost->owner->email;
				}

				if ( Request::input('alert') ) {
					Mail::send('emails/post/new', array("post" => $post, "emails" => $emails), function($message) use($emails, $post, $postLocation) {
						$message
							->to($emails)
							->subject('Ringmaster - New Post: '.$post->name.' - '.$postLocation->name)
							->from(Config::get('ringmaster.alert_email'), Config::get('ringmaster.alert_name'));
					});
				}

				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> [
						"refresh" => true
					]
				));


			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "new-post-save"
				), 400);
			}

			
		}
	}




	public function show($id) {

		$post = Post::findOrFail($id);

		if ($post->parentPost()) {
			return Redirect::action("PostController@show", $post->parentPost->id);
		}


		$data = array(
			"post" 				=> Post::findOrFail($id),
			"me" 				=> Auth::user()
		);

		if (Request::ajax()) return View::make('ajax', $data)
				->nest('content', 'post.show', $data);

		return View::make('template', $data)
				->nest('breadcrumbs', 'breadcrumbs', array("end" => Post::findOrFail($id)))
				->nest('content', 'post.show', $data);
	}

}
