<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Twitter extends Controller
{

	/** @var OAuth Twitter Service Handle */
    private $tw;

    public function __construct(){
    	$this->tw = \OAuth::consumer('Twitter');
    }

    /**
     * @param  Request
     * @return redirect
     */
    public function authApp(Request $request){
    	$token  = $request->get('oauth_token');
		$verify = $request->get('oauth_verifier');

		if( ! is_null($token) && ! is_null($verify) )		
		{
			// Get token
			$token = $this->tw->requestAccessToken($token, $verify);
			return redirect("/");
		}else{
	    	// get request token
			$reqToken = $this->tw->requestRequestToken();
			
			// get Authorization Uri sending the request token
			$url = $this->tw->getAuthorizationUri(['oauth_token' => $reqToken->getRequestToken()]);

			// return to twitter login url
			return redirect((string)$url);
		}
    }

    public function twCallback( Request $request ){
    	$token  = $request->get('oauth_token');
		$verify = $request->get('oauth_verifier');

		if( ! is_null($token) && ! is_null($verify) )		
		{
			// Get token
			$token = $this->tw->requestAccessToken($token, $verify);
		}
    }
}
