<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Auth, View, Request, Validator,  Redirect, Response, Mail, Config;


class HomeController extends Controller {


	public function index()
	{
		
		// begin FILTER replacements (just for the home controller)

		if (Auth::guest()) 
		{
			return View::make('template')->nest('content', 'home.guest');
		}

		if (!Auth::user()->validated) {
			return Redirect::action('UserController@tokenNotValidated');
		}
	
		if (!Auth::user()->initial_setup_completed) {
			return Redirect::action('SetupController@index');
		}

		// end FILTER replacements (just for the home controller)


		$events = array();
		foreach (Auth::user()->classrooms as $c) {
			$events = array_merge($events, $c->futureEvents->all());
		}
		usort($events, array($this, "sortByStart"));


		$posts = array();
		foreach (Auth::user()->classrooms as $c) {
			$posts = array_merge($posts, $c->recentPosts->all());
		}
		usort($posts, array($this, "sortByCreatedAt"));


		$assignments = array();
		foreach (Auth::user()->classrooms as $c) {
			$assignments = array_merge($assignments, $c->futureAssignments->all());
		}
		usort($assignments, array($this, "sortByDue"));

			
		$data = array(
			"titles" =>				array("Dashboard"),
			"events" =>				$events,
			"posts" =>				array_reverse($posts),
			"assignments" =>		$assignments
		);

		return View::make('template', $data)->nest('content', 'home.index', $data);
	}

	private function sortByStart($a, $b) {
    	return strcmp($a->start, $b->start);
	}

	private function sortByCreatedAt($a, $b) {
    	return strcmp($a->created_at, $b->created_at);
	}

	private function sortByDue($a, $b) {
    	return strcmp($a->due, $b->due);
	}



}
