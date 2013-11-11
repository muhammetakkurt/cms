@extends('layouts.admin')
@section('title')
	{{ $user->first_name.' '.$user->last_name.' Düzenleme' }}
@stop
@section('content')
<legend>Kullanıcı Düzenleme</legend>
	{{	Form::open(array('url' => 'users/'.$user->id , 'method' => 'put'))	}}
	{{	Form::label('group', 'Grup')	}}
	{{	Form::select('group', $groups, $group_id)	}}

	{{	Form::label('city', 'Şehir')	}}
	{{	Form::select('city', $cities , $user->city_id , array('onchange' => 'javascript:getTowns(this.value);'))	}}

	{{	Form::label('town', 'İlçe')	}}
	{{	Form::select('town', $towns , $user->town_id , array('id' => 'towns'))}}
	{{	Form::label('first_name', 'Adı')	}}
	{{	Form::text('first_name',$user->first_name,array('placeholder' => 'Adı', 'required' => ''))	}}<br/>
	{{	Form::label('last_name', 'Soyadı')	}}
	{{	Form::text('last_name',$user->last_name,array('placeholder' => 'Soyadı', 'required' => ''))	}}<br/>
	{{	Form::label('email', 'E-posta')	}}
	{{	Form::text('email',$user->email,array('placeholder' => 'E-posta', 'required' => ''))	}}
	
	{{	Form::label('password', 'Şifre')	}}
	<input type="password" name="password" placeholder="Şifre"/><br/>
	
	{{ 	Form::submit('Kaydet',array('class' => 'btn btn-primary')) }}
	{{ 	Form::close() }}
@stop

@section('footerScripts')
	@include('plugins.getTowns')	
@stop