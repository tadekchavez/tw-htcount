<!DOCTYPE html>
<html ng-app="htcount">

<head>

<title>Twitter HT Count</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" />
<link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/set1.css') }}" />

<script src="{{ URL::asset('js/app.js') }}"></script>
<script src="{{ URL::asset('js/classie.js') }}"></script>
</head>

<body>
	@yield('content')
</body>
</html>