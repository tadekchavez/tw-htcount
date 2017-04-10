# tw-htcount

Displays 10 (default) tweets from a Twitter account and displays a summary of all the different hashtags in them with the number of repetitions of each one.


## Installation

1. Using the provided composer.json, install dependencies `$ composer install`
2. Create configuration file for OAuth package [https://github.com/oriceon/oauth-5-laravel](https://github.com/oriceon/oauth-5-laravel)
```
$ php artisan vendor:publish
```
3. Add your twitter app credentials (Or create a new app [Twitter App Management](https://apps.twitter.com/)) to `config/oauth-5-laravel.php` 



## Usage

1. Access `/public` directory the application root. i.e.
```http://localhost/tw-htcount/public```

2. The first time you use the application it will automatically redirect to twitter for you to approve and authenticate.

3. Twitter will redirect back to tw-htcount and will show an input.

3. Type in a Twitter username on the input field and press Enter (Probably try with an account that "over-uses" hashtags)
  
There is an additional option to get directly request information by passing parameters in the url. These parameters are: {screen_name}, {num_tweets} (optional) and {response_type} (optional) and could be inclued as:
```http://app_base_url/public/screen_name/num_tweets```

For example, the following url will display the last 40 tweets from the Twitter account '@nixcraft':
```http://app_base_url/public/nixcraft/40```

For example, the following uri will display the last 20 tweets from the Twitter account '@thenextweb' in json format:
```http://app_base_url/public/TheNextWeb/20/json```

## Assumptions
- The user account to fetch has to be public. No data will be shown in case is a protected account.
- Defining the number of tweets to fetch from a url parameter could be limited by Twitter API.