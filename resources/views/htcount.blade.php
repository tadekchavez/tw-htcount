@extends('layouts.app')
@section('content')

<div class="full-width" id="usr-input-container">
	<span class="input input--hoshi">
		<input type="text" name="screen_name" id="screen_name" class="input__field input__field--hoshi" pattern="[A-Za-z0-9_]+" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="screen_name">
			<span class="input__label-content input__label-content--hoshi">Twitter Username</span>
		</label>
	</span>
</div>

<div id="ht" class="flex-container">
	<div class="half-width" id="user-tweets-container">
		<h2>Last {{ $countTweets }} tweets</h2>
	@foreach ($tweets as $tweet)
		@include( 'partials.tweet', array('tweet', $tweet))
		
	@endforeach
	</div>

	<div class="half-width" id="ht-count-container">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.		
	</div>
</div>


<div class="container">

<div ng-view></div>

</div> <!-- /container -->

@endsection