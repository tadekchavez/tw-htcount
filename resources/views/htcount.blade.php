@extends('layouts.app')
@section('content')

<!-- Form wrapper -->
<div class="full-width" id="usr-input-container">
	<form action="{{ action('Tweets@fetchTweets') }}" method="POST">
    	{{ csrf_field() }}
		<span class="input input--hoshi">
			<input type="text" name="screen_name" id="screen_name" class="input__field input__field--hoshi" value="{{ $screen_name }}" pattern="[A-Za-z0-9_]+" />
			<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="screen_name">
				<span class="input__label-content input__label-content--hoshi">Twitter Username</span>
			</label>
		</span>
		<input type="hidden" value="10" name="num_tweets" />
		<input type="submit" style="position: absolute; left: -9999px"/>
	</form>

</div>
<!--end Form Wrapper -->

<div id="ht" class="flex-container">
	<!--Tweets Container-->
	<div class="half-width" id="user-tweets-container">
		<h2>
			@if ( $countTweets === 1 )
				Last tweet
			@elseif( $countTweets > 0 )
				Last {{ $countTweets }} tweets
			@else
				Results
			@endif
		</h2>
	@foreach ($tweets as $tweet)
		@include( 'partials.tweet', array('tweet', $tweet))
	@endforeach
	</div>
	<!-- end Tweets Container-->

	<!-- Hashtags Container -->
	<div class="half-width" id="ht-count-container">
		@if( $screen_name == '' )
			<p>
				Just type the username and hit ENTER to see up to {{ $numTweets}} of the most recent tweets and its hashtags ocurrences.
			</p>
		@else
			<h2>Hashtag Count</h2>
			<div id="hashtags-wrapper">
			@foreach ($hashtags as $key => $ht)
				<div class="ht-item">
					<a href="https://twitter.com/search?q=%23{{$key}}" target="_blank">
						{{ $key }} 
					</a>
					( {{ $ht }} )
				</div>
			@endforeach
			</div>
		@endif
	</div>
	<!-- End Hashtags Container -->
</div>

@endsection