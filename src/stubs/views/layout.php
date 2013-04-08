<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Dais Scaffold {{ isset($title) ? ' - ' . $title : ''}}</title>
	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/font-awesome.min.css')}}">
	<style>
		body {
			padding-top: 60px;
			padding-bottom: 40px;
		}
		@yield('styles')
	</style>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-responsive.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">

	<script src="{{ URL::asset('js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>
<body>
	<!--[if lt IE 7]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->

	<div class="container">
		<div class="row flash">
			@foreach (array('error', 'alert', 'success', 'info') as $type)
				@if ( Session::get($type) )
					<div class="alert alert-{{$type}}">
						<a class="close" data-dismiss="alert">&times;</a>
						<p>{{ Session::get($type) }}</p>
					</div>
				@endif
			@endforeach
		</div>
		@yield('content')
	</div> <!-- /container -->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>window.jQuery || document.write(
			'<script src="{{ URL::asset('js/vendor/jquery-1.9.1.min.js') }}"><\/script>'
		)
	</script>

	<script src="{{ URL::asset('js/vendor/bootstrap.min.js') }}"></script>

	<script src="{{ URL::asset('js/main.js') }}"></script>
	<script>
	@yield('scripts')
	$(function(){
	    $('[data-method]').append(function(){
	        return "\n"+
	            "<form action='"+$(this).attr('href')+"' method='POST' style='display:none'>\n"+
	            "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
	            "</form>\n"
	    })
	    .removeAttr('href')
	    .attr('style','cursor:pointer;')
	    .attr('onclick','$(this).find("form").submit();');
	});
	</script>
</body>
</html>
