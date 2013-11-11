@extends('layouts.site')
@section('title')
	{{ $article->title }}
@stop

@section('content')
	<h1>{{ $article->title }}</h1>
	<h2>{{ $article->summary }}</h2>
	<p>{{ $article->content }}</p>
@stop