@extends('layouts.admin')
@section('content')
<div class="span12 header">
  <h4>Profilim</h4>
</div>
<div class="span12">
  {{ Form::open(array('url' => 'profile' , 'method' => 'post' , 'class' => 'form-horizontal' ,  'files' => true)) }}

  <div class="span6">
      <div class="control-group">
        <label for="email" class="control-label">E-Posta </label>
        <div class="controls">
          {{Form::token()}}
          {{Form::text('email', Sentry::getUser()->email, array('placeholder' => 'E-Posta', 'required' => ''))}}
        </div>
      </div>
      <div class="control-group">
        <label for="first_name" class="control-label">Ad</label>
        <div class="controls">
          {{Form::text('first_name', Sentry::getUser()->first_name, array('placeholder' => 'Ad', 'required' => ''))}}
        </div>
      </div>
      <div class="control-group">
        <label for="last_name" class="control-label">Soyad</label>
        <div class="controls">
          {{Form::text('last_name', Sentry::getUser()->last_name, array('placeholder' => 'Soyad', 'required' => ''))}}
        </div>
      </div>
      <div class="control-group"> 
        <div class="controls">
          <button type="submit" class="btn">Kaydet</button>
        </div>
      </div>
    {{ Form::close()}}
  </div>
</div>

@stop
