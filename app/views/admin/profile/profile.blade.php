@extends('layouts.admin')
@section('title')
  Profilim
@stop
@section('content')
<div class="row">
  <div class="col-md-12">
  <legend>Profilim</legend>
    {{ Form::open(array('url' => 'profile' , 'method' => 'post' , 'class' => 'form-horizontal' ,  'files' => true)) }}

    <div class="col-md-6">
        <div class="control-group">
          <label for="email" class="control-label">E-Posta </label>
          <div class="controls">
            {{Form::token()}}
            {{Form::text('email', Sentry::getUser()->email, array('class' => 'form-control' , 'placeholder' => 'E-Posta', 'required' => ''))}}
          </div>
        </div>
        <div class="control-group">
          <label for="first_name" class="control-label">Ad</label>
          <div class="controls">
            {{Form::text('first_name', Sentry::getUser()->first_name, array('class' => 'form-control' , 'placeholder' => 'Ad', 'required' => ''))}}
          </div>
        </div>
        <div class="control-group">
          <label for="last_name" class="control-label">Soyad</label>
          <div class="controls">
            {{Form::text('last_name', Sentry::getUser()->last_name, array('class' => 'form-control' , 'placeholder' => 'Soyad', 'required' => ''))}}
          </div>
        </div>
        <br>
        <div class="control-group"> 
          <div class="controls">
            <button type="submit" class="btn btn-warning">Kaydet</button>
          </div>
        </div>
      {{ Form::close()}}
    </div>
  </div>
</div>
@stop
