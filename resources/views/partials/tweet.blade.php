<div class="tweet-container">
	<div class="tweet-description">
		{{$tweet->text}}
	</div>
	<div class="tweet-date">
		{{ date("h:i a - d M Y", strtotime($tweet->created_at))}}
	</div>

</div>