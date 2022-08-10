<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;


use App\Models\CalendarEvent;
use App\Models\Classroom;
use App\Models\Post;

use Auth, View, Request, Validator, Response, Carbon;


class CalendarEventController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        // TODO restrict creation to class admins
    }


	public function show($id) {
		$data = array(
			"event" => CalendarEvent::findOrFail($id),
			"me" 	=> Auth::user()
		);

		if (Request::ajax()) return View::make('ajax', $data)
				->nest('content', 'event.show', $data);

		return View::make('template', $data)
				->nest('breadcrumbs', 'breadcrumbs', array("end" => CalendarEvent::findOrFail($id)))
				->nest('content', 'event.show', $data);
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

		if (Request::ajax()) return View::make('ajax', $data)->nest('content', 'event.create', $data);
		return View::make('template', $data)->nest('content', 'event.create', $data);
	}




	public function store() {

		$type = Request::input('belongs_to_type');
		
		$rules = CalendarEvent::$rules;

		$validator = Validator::make(
			Request::all(),
			$rules	
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

			$emails = array();
			$eventLocation;
			if ($type == "classroom") {
				$eventLocation = Classroom::findOrFail(Request::input('belongs_to_id'));
			}
			foreach ($eventLocation->users as $u) {
				$emails[] = $u->email;
			}
			
			$start_exploded = explode("-", Request::input('start_date'));
			$end_exploded = explode("-", Request::input('end_date'));

			$start_time_exploded = explode(":", str_replace(" ", ":", Request::input('start_time')) );
			$end_time_exploded = explode(":", str_replace(" ", ":", Request::input('end_time')) );

			$start_time_hour = $start_time_exploded[0];
			$start_time_mins = $start_time_exploded[1];
			if ($start_time_exploded[2] == "PM") $start_time_hour += 12;

			$end_time_hour = $end_time_exploded[0];
			$end_time_mins = $end_time_exploded[1];
			if ($end_time_exploded[2] == "PM") $end_time_hour += 12;

			$event = new CalendarEvent;
			$event->name = 				Request::input('name');
			$event->content = 			Request::input('content');
			$event->start = 			Carbon::create($start_exploded[2], $start_exploded[0], $start_exploded[1], $start_time_hour, $start_time_mins);
			$event->end = 				Carbon::create($end_exploded[2], $end_exploded[0], $end_exploded[1], $end_time_hour, $end_time_mins);
			
			$event->belongs_to_type =	Request::input('belongs_to_type');
			$event->belongs_to_id =	 	Request::input('belongs_to_id');

			$event->owner_id = 			Auth::user()->id;

			if ($event->save()) {
				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> [
						"refresh" => true
					]
				));
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "new-event-save"
				), 400);
			}

			
		}
	}



}
