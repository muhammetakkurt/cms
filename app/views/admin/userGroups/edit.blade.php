@extends('layouts.admin')
@section('title')
	{{$usergroup['name'].' Grubu Düzenleme'}}
@stop
@section('content')
<legend>{{$usergroup['name'].' Grubu Düzenleme'}} </legend>
	{{	Form::open(array('url' => 'users-groups/'.$usergroup['id'] , 'method' => 'PUT'))	}}
	{{	Form::label('name', 'Grup Adı')	}}
	{{	Form::text('name',$usergroup['name'],array('placeholder' => 'Grup Adı', 'required' => '')) }}
	{{	Form::label('permissions', 'Permissions')	}}
	{{ 	Form::submit('Kaydet',array('class' => 'btn btn-primary')) }}
	{{ 	Form::close() }}
@stop