@extends('layouts.site')
@section('title')
  Kayıt Ol
@stop
@section('content')
  <div class="row">
    <div class="span6 offset3">
      <div class="login">
        {{ Form::open(array( 'url' => 'newuser' , 'method' => 'POST' , 'class' => 'form-horizontal')) }}
          <div class="control-group">
            <label for="email" class="control-label">İsim </label>
            <div class="controls">
              {{ Form::text( 'first_name', (isset($first_name) ? $first_name : '') ,array('placeholder' => 'İsim', 'id' => 'first_name' , 'required' => '') ) }}
            </div>
          </div>
          <div class="control-group">
            <label for="email" class="control-label">Soyisim </label>
            <div class="controls">
              {{ Form::text( 'last_name', (isset($last_name) ? $first_name : '') ,array('placeholder' => 'Soyisim', 'id' => 'last_name' , 'required' => '') ) }}
            </div>
          </div>
          <div class="control-group">
            <label for="email" class="control-label">Email </label>
            <div class="controls">
              {{ Form::text( 'email', '',array('placeholder' => 'E-posta', 'id' => 'email1' , 'required' => '') ) }}
              {{ Form::hidden( 'twitter_id', (isset($twitter_account_id) ? $twitter_account_id : '') ) }}
            </div>
          </div>
          <div class="control-group">
            <label for="inputPassword" class="control-label">Şifre</label>
            <div class="controls">
              <input type="password" name="password" placeholder="Şifre" required>
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <div class="pull-left" style="margin-right: 20px;">
                {{ Form::button( 'Kayıt ol', array('type' => 'submit', 'class' => 'btn') ) }}
              </div>
            </div>
          </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@stop