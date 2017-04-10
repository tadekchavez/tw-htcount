<?php

//Tweets & Hashtags
Route::get('/', "Tweets@show"); //Empty form, first screen for user
Route::get('/show/{screen_name?}/{num_tweets?}/{response_type?}', "Tweets@show"); //endpoint to display information based on parameters
Route::post('/fetchTweets', "Tweets@fetchTweets"); // Form action


//Twitter Auth
Route::get('/authApp', "Twitter@authApp"); //Twitter API authentication