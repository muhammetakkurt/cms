@extends('layouts.admin')
@section('title')
	Grup Oluşturma
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<legend>Kullanıcı Grubu Oluşturma</legend>
		
		{{	Form::open(array('url' => 'users-groups, 'method' => 'PUT'))	}}
		<div class="row">
			<div class="col-md-12">
				{{	Form::label('name', 'Grup Adı')	}}
			</div>
			<div class="col-md-4">
				{{	Form::text('name', '' ,array('placeholder' => 'Grup Adı', 'required' => '' , 'class' => 'form-control')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ 	Form::submit('Kaydet',array('class' => 'btn btn-primary')) }}	
			</div>
		</div>
		{{ 	Form::close() }}
	</div>
</div>
@stop