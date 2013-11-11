@section('headerPluginStyles')
	{{ HTML::style('assets/css/datepicker.css') }}
	<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" media="screen" href="{{URL::asset('assets/elfinder/css/elfinder.min.css')}}">
	<link rel="stylesheet" type="text/css" media="screen" href="{{URL::asset('assets/elfinder/css/theme.css')}}">
	<style type="text/css">
		form img 
		{
			cursor: pointer;
		}
	</style>
@stop
@section('headerPluginScripts')
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="{{URL::asset('assets/elfinder/js/elfinder.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/elfinder/js/i18n/elfinder.tr.js')}}"></script>
@stop