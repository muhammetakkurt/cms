@extends('layouts.admin')

@section('title')
	Dosya Yönetimi
@stop
@include('plugins.elfinder')
@section('content')
	<div id="elfinder">

	</div>
@stop
@section('footerJqueries')
	var elf = $('#elfinder').elfinder({
				url : '{{URL::to('assets/elfinder/php/connector.php')}}',  // connector URL (REQUIRED)
				 lang: 'tr'
			}).elfinder('instance');
@stop
