@extends('layouts.admin')
@section('title')
	{{$usergroup['name'].' Grubu Düzenleme'}}
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<legend>{{$usergroup['name'].' Grubu Düzenleme'}} </legend>
		
		{{	Form::open(array('url' => 'users-groups/'.$usergroup['id'] , 'method' => 'PUT'))	}}
		<div class="row">
			<div class="col-md-12">
				{{	Form::label('name', 'Grup Adı')	}}
			</div>
			<div class="col-md-4">
				{{	Form::text('name',$usergroup['name'],array('placeholder' => 'Grup Adı', 'required' => '' , 'class' => 'form-control')) }}
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