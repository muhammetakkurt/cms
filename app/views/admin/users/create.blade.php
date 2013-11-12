@extends('layouts.admin')
@section('title')
	Kullanıcı Ekleme
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<legend>Kullanıcı Oluşturma</legend>
		{{	Form::open(array('url' => 'users', 'method' => 'put'))	}}
		<div class="row">
			<div class="col-md-1">
				{{	Form::label('group', 'Grup')	}}
			</div>
			<div class="col-md-3">
				{{	Form::select('group', $groups, null , array('class' => 'form-control'))	}}
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-1">
				{{	Form::label('first_name', 'Adı')	}}
			</div>
			<div class="col-md-3">
				{{	Form::text('first_name', '' ,array('class' => 'form-control' , 'placeholder' => 'Adı', 'required' => ''))	}}
			</div>
		</div>

		<div class="row">
			<div class="col-md-1">
				{{	Form::label('last_name', 'Soyadı')	}}
			</div>
			<div class="col-md-3">
				{{	Form::text('last_name', '' ,array('class' => 'form-control' , 'placeholder' => 'Soyadı', 'required' => ''))	}}
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-1">
				{{	Form::label('email', 'E-posta')	}}
			</div>
			<div class="col-md-3">
				{{	Form::text('email', '' ,array('class' => 'form-control' , 'placeholder' => 'E-posta', 'required' => ''))	}}
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-1">
				{{	Form::label('password', 'Şifre')	}}
			</div>
			<div class="col-md-3">
				<input type="password" name="password" class="form-control"  placeholder="Şifre"/>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-1">
				{{ 	Form::submit('Kaydet',array('class' => 'btn btn-primary')) }}
			</div>
		</div>
		
		
		{{ 	Form::close() }}
	</div>
</div>
@stop