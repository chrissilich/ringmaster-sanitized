<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CodesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('course_code_pieces')->delete();

		//CodePiece::create(array('content' => ''));


		CodePiece::create(array('content' => 'ice'));
		CodePiece::create(array('content' => 'fire'));
		CodePiece::create(array('content' => 'water'));
		CodePiece::create(array('content' => 'earth'));
		CodePiece::create(array('content' => 'warm'));
		CodePiece::create(array('content' => 'stink'));
		CodePiece::create(array('content' => 'pacman'));
		CodePiece::create(array('content' => 'mario'));
		CodePiece::create(array('content' => 'link'));
		CodePiece::create(array('content' => 'zelda'));
		CodePiece::create(array('content' => 'sonic'));
		CodePiece::create(array('content' => 'yoshi'));
		CodePiece::create(array('content' => 'dexter'));
		CodePiece::create(array('content' => 'locust'));
		CodePiece::create(array('content' => 'flank'));
		CodePiece::create(array('content' => 'ball'));
		CodePiece::create(array('content' => 'firefly'));
		CodePiece::create(array('content' => 'buffy'));
		CodePiece::create(array('content' => 'vampire'));
		CodePiece::create(array('content' => 'sparkle'));
		CodePiece::create(array('content' => 'alpha'));
		CodePiece::create(array('content' => 'beta'));
		CodePiece::create(array('content' => 'gamma'));
		CodePiece::create(array('content' => 'llama'));
		CodePiece::create(array('content' => 'karate'));
		CodePiece::create(array('content' => 'lobster'));
		CodePiece::create(array('content' => 'hostel'));
		CodePiece::create(array('content' => 'hipster')); 
		CodePiece::create(array('content' => 'bacon')); 
		CodePiece::create(array('content' => 'meat')); 
		CodePiece::create(array('content' => 'rib')); 
		CodePiece::create(array('content' => 'riblet')); 
		CodePiece::create(array('content' => 'steak'));
		CodePiece::create(array('content' => 'chair')); 
		CodePiece::create(array('content' => 'pancake')); 
		CodePiece::create(array('content' => 'statue')); 
		CodePiece::create(array('content' => 'unicorn')); 
		CodePiece::create(array('content' => 'rainbow'));
		CodePiece::create(array('content' => 'laser'));
		CodePiece::create(array('content' => 'senor')); 
		CodePiece::create(array('content' => 'bunny')); 
		CodePiece::create(array('content' => 'captain'));
		CodePiece::create(array('content' => 'fantastic')); 
		CodePiece::create(array('content' => 'nibble'));
		CodePiece::create(array('content' => 'fry'));
		CodePiece::create(array('content' => 'bipolar'));
		CodePiece::create(array('content' => 'carrot'));
		CodePiece::create(array('content' => 'people')); 
		CodePiece::create(array('content' => 'sock'));
		CodePiece::create(array('content' => 'gnomes')); 
		CodePiece::create(array('content' => 'glitter')); 
		CodePiece::create(array('content' => 'potato')); 
		CodePiece::create(array('content' => 'salad')); 
		CodePiece::create(array('content' => 'curtain'));
		CodePiece::create(array('content' => 'beets')); 
		CodePiece::create(array('content' => 'toilet')); 
		CodePiece::create(array('content' => 'exorcism')); 
		CodePiece::create(array('content' => 'stick'));
		CodePiece::create(array('content' => 'mermaid'));
		CodePiece::create(array('content' => 'egg')); 
		CodePiece::create(array('content' => 'sea'));
		CodePiece::create(array('content' => 'barnacle')); 
		CodePiece::create(array('content' => 'dragon')); 
		CodePiece::create(array('content' => 'jellybean')); 
		CodePiece::create(array('content' => 'snake')); 
		CodePiece::create(array('content' => 'doll')); 
		CodePiece::create(array('content' => 'cookie')); 
		CodePiece::create(array('content' => 'apple'));
		CodePiece::create(array('content' => 'birthday'));
		CodePiece::create(array('content' => 'ferret')); 
		CodePiece::create(array('content' => 'dot')); 
		CodePiece::create(array('content' => 'wheel')); 
		CodePiece::create(array('content' => 'bouncy'));
		CodePiece::create(array('content' => 'pizza')); 
		CodePiece::create(array('content' => 'puppy')); 
		CodePiece::create(array('content' => 'beanie')); 
		CodePiece::create(array('content' => 'jet'));
		CodePiece::create(array('content' => 'ski')); 
		CodePiece::create(array('content' => 'monkey')); 
		CodePiece::create(array('content' => 'cupcake')); 
		CodePiece::create(array('content' => 'barrel')); 
		CodePiece::create(array('content' => 'wrinkle')); 
		CodePiece::create(array('content' => 'towelette')); 
		CodePiece::create(array('content' => 'telephone')); 
		CodePiece::create(array('content' => 'pillow')); 
		CodePiece::create(array('content' => 'milk')); 
		CodePiece::create(array('content' => 'snow')); 
		CodePiece::create(array('content' => 'rain')); 
		CodePiece::create(array('content' => 'hair')); 
		CodePiece::create(array('content' => 'bakery'));   
		CodePiece::create(array('content' => 'graveyard')); 
		CodePiece::create(array('content' => 'pistol')); 
		CodePiece::create(array('content' => 'whip')); 
		CodePiece::create(array('content' => 'wiener')); 
		CodePiece::create(array('content' => 'hotdog')); 
		CodePiece::create(array('content' => 'suitcase'));
		CodePiece::create(array('content' => 'banjo')); 
		CodePiece::create(array('content' => 'opera'));
		CodePiece::create(array('content' => 'singer'));
		CodePiece::create(array('content' => 'circus'));
		CodePiece::create(array('content' => 'trampoline'));
		CodePiece::create(array('content' => 'carousel'));
		CodePiece::create(array('content' => 'carnival'));
		CodePiece::create(array('content' => 'locomotive'));
		CodePiece::create(array('content' => 'mantis'));
		CodePiece::create(array('content' => 'fart'));
		CodePiece::create(array('content' => 'poop'));
		CodePiece::create(array('content' => 'bum'));
		CodePiece::create(array('content' => 'snot'));
		CodePiece::create(array('content' => 'tube'));
		CodePiece::create(array('content' => 'goo'));
		CodePiece::create(array('content' => 'booger'));
		CodePiece::create(array('content' => 'blizzard'));
		CodePiece::create(array('content' => 'candle'));
		CodePiece::create(array('content' => 'wax'));
		CodePiece::create(array('content' => 'chicken'));
		CodePiece::create(array('content' => 'foot'));
		CodePiece::create(array('content' => 'dong'));
		CodePiece::create(array('content' => 'paste'));
		CodePiece::create(array('content' => 'wobble'));
		CodePiece::create(array('content' => 'brim'));
		CodePiece::create(array('content' => 'tug'));
		CodePiece::create(array('content' => 'log'));
		CodePiece::create(array('content' => 'knob'));
		CodePiece::create(array('content' => 'banana'));
		CodePiece::create(array('content' => 'toot'));
		CodePiece::create(array('content' => 'band'));
		CodePiece::create(array('content' => 'nerd'));
		CodePiece::create(array('content' => 'geek'));
		CodePiece::create(array('content' => 'magic'));
		CodePiece::create(array('content' => 'brute'));
		CodePiece::create(array('content' => 'pope'));
		CodePiece::create(array('content' => 'trapeze'));
		CodePiece::create(array('content' => 'tent'));
		CodePiece::create(array('content' => 'brag'));
		CodePiece::create(array('content' => 'wiggle'));

	}

}