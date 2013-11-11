@extends('layouts.site')
@section('title')
	Sayfa
@stop

@section('content')
	@foreach($pages as $page)
		<h1>{{ $page->name }}</h1>
		
		@foreach($page->articles as $article)
			<h2>{{ $article->title }}</h2>
			<h2>{{ $article->summary }}</h2>
			<p>{{ $article->content }}</p>
		@endforeach
	@endforeach
@stop