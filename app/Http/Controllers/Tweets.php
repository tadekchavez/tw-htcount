<?php

namespace App\Http\Controllers;
use \Exception as Exception;

use Illuminate\Http\Request;

class Tweets extends Controller
{
	private $twCount;
	private $tw;

	private $tweets = [];
	private $hashtags = [];
	private $linkified = [];
	private $twUser = '';

	public function __construct()
	{
		// Twitter Auth Service
		$this->tw = \OAuth::consumer('Twitter');
		// Amount of tweets to fetch. Configurable as env variable (/.env file)
		$this->twCount = env('NUM_TWEETS_FETCH', '10');
	}
    
    /**
     * Displays tweets and hashtags for the specified user
     * This method allows request for json response so an implementation of a single page app on the frontend
     * wouldn't affect the backed
     * @param  [type] $screen_name   Twitter username of the account to fetch data from
     * @param  [type] $num_tweets    Qty of tweets to fetch
     * @param  [type] $response_type Type of response ['', 'json']
     * @return view             
     */
    public function show($screen_name = null, $num_tweets = null, $response_type = null){  
    	if ( $screen_name != null ) $this->setProperties($screen_name, $num_tweets);

    	if( $response_type != null && $response_type = 'json'){
    		return $this->tweets;
    	}else{
    		return view('htcount', ['tweets'=>$this->tweets, 'countTweets' => count($this->tweets), 'numTweets' => $this->twCount, 'hashtags' => $this->hashtags,  'screen_name' => $this->twUser]);
    	}
    }

    /**
     * Form action. 
     * Method that takes care of receiving data from input form (screen_name)
     * @param  Request $request 
     * @return Redirect           
     */
    public function fetchTweets(Request $request)
    {
    	$this->setProperties($request->input('screen_name'), $request->input('num_tweets') );
    	return redirect('show/'.$this->twUser.'/'.$this->twCount);
    }

    /**
     * Sets & prepares properties
     * @param String  $screen_name Twitter username from which account the app will fetch tweets
     * @param integer $num_tweets  Qty of tweets to fetch
     */
    private function setProperties($screen_name, $num_tweets = 10){
    	$this->twUser = $screen_name;
    	$this->twCount = $num_tweets != null ? $num_tweets : $this->twCount;

    	$this->tweets = $this->getTweetsFromUser();

    	if(!is_array($this->tweets)) $this->tweets = [];
    	$this->processHashtags();
    }

    /**
     * Loops through each hashtag on every tweet to keep count of its repetitions and
     * to change the hashtag plain text for a html tag to make it linkable when displayed.
     * It also sorts the array with counts of hashtags (Desc)
     * @return [type] 
     */
    private function processHashtags(){
    	foreach($this->tweets as $tweet){
    		foreach($tweet->entities->hashtags as $ht){
    			$tweet->text = $this->linkifyHashtag($ht->text, $tweet->text);
    			$this->incrementHTOcurrence($ht->text);
    		}
    	}
    	arsort($this->hashtags);
    }

    /**
     * Substitution of plain hashtag text for html <a href=""> to display linkable hashtags
     * @param  String $ht   Hashtag text
     * @param  String $text Tweet text
     * @return String       Changed text (or not)
     */
    private function linkifyHashtag($ht, $text){
        if (in_array($ht, $this->linkified)) {
            return $text;
        }
        $this->linkified[] = $ht;

        return preg_replace('/#\b' . $ht . '\b/', sprintf('<a href="https://twitter.com/search?q=%%23%2$s" target="_blank">#%1$s</a>', $ht, urlencode($ht)), $text);
    }

    /**
     * Increments counter for a particuar hashtag. Used everytime a new hashtag is found.
     * @param  String $ht Hashtag text
     * @return
     */
    private function incrementHTOcurrence($ht){
    	if(isset($this->hashtags[$ht])) $this->hashtags[$ht]++;
    	else $this->hashtags[$ht] = 1;
    }

    /**
     * Checks if the current session has a bearer token registered 
     * @return boolean True if the token exist, false if it doesn't
     */
    private function isAuthenticated(){
		if( $this->tw->getStorage()->hasAccessToken("Twitter") ) return true;
		else return false;
	}

	/**
	 * If Authenticated, Requests Twitter API for a particuar user's timeline.
	 * Limited to configured (env variable)/specified (url) $this->twCount 
	 * 
	 * @return [type] [description]
	 */
    private function getTweetsFromUser(){
    	if( !$this->isAuthenticated() ) return redirect()->action('Twitter@authApp');

    	try{ 
    		return json_decode($this->tw->request("statuses/user_timeline.json?screen_name=".$this->twUser."&count=$this->twCount"));
    	}catch( Exception $e ){
    		if($e instanceof \OAuth\Common\Storage\Exception\TokenNotFoundException){ 
    			// If we couldn't connect we try to Auth.
    			return redirect()->action('Twitter@authApp');
    		}else{
    			// Every other problem with the requested twitter account (see assumptions Readme.md)
    			return "There's a problem with that twitter account.";
    		}
    	}
    }


}
