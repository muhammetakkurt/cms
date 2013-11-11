@extends('layouts.admin')
@section('title')
	Grup Oluşturma
@stop
@section('content')
<legend>Kullanıcı Grubu Oluşturma</legend>
	{{	Form::open(array('url' => 'users-groups' , 'method' => 'post'))	}}
	{{	Form::label('name', 'Grup Adı')	}}
	{{	Form::text('name','',array('placeholder' => 'Grup Adı', 'required' => '')) }}
	{{	Form::label('permissions', 'Permissions')	}}
	{{ 	Form::submit('Ekle',array('class' => 'btn btn-primary')) }}
	{{ 	Form::close() }}
@stop