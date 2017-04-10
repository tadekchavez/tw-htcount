<?php

namespace App\Http\Controllers;
use \Exception as Exception;

use Illuminate\Http\Request;

class HtCount extends Controller
{
	private $twCount;
	private $tw;

	public function __construct()
	{
		// Twitter Auth Service
		$this->tw = \OAuth::consumer('Twitter');
		// Amount of tweets to fetch. Configurable as env variable (/.env file)
		$this->twCount = env('NUM_TWEETS_FETCH', '10');

	}
    
    public function show(Request $request){
    	
    	try{
    		$res = json_decode($this->tw->request("statuses/user_timeline.json?screen_name=tadekchavez&count=$this->twCount"), true);
    	}catch( Exception $e ){
    		if($e instanceof \OAuth\Common\Storage\Exception\TokenNotFoundException){ 
    			// If we couldn't connect we try to Auth. 
    			return redirect()->action('Twitter@authApp');
    		}else{
    			return "There's a problem with that twitter account.";
    		}
    	} 

    	return $res;

    	//return view('htcount');
    }
}
