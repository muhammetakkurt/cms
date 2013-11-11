@extends('layouts.admin')
@section('title')
	Kullanıcı Ekleme
@stop
@section('content')
<legend>Kullanıcı Oluşturma</legend>
	{{	Form::open(array('url' => 'users' , 'method' => 'post','files' => true))	}}
	{{	Form::label('group', 'Grup')	}}
	{{	Form::select('group', $groups)	}}
	{{	Form::label('first_name', 'Adı')	}}
	{{	Form::text('first_name','',array('placeholder' => 'Adı', 'required' => ''))	}}<br/>
	{{	Form::label('last_name', 'Soyadı')	}}
	{{	Form::text('last_name','',array('placeholder' => 'Soyadı', 'required' => ''))	}}<br/>
	{{	Form::label('email', 'E-posta')	}}
	<input type="email" name="email" placeholder="E-posta" required>
	
	{{	Form::label('password', 'Şifre')	}}
	<input type="password" name="password" placeholder="Şifre" required/><br/>
	
	{{ 	Form::submit('Ekle',array('class' => 'btn btn-primary')) }}
	{{ 	Form::close() }}
@stop