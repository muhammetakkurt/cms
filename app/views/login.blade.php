@extends('layouts.site')
@section('title')
  Giriş
@stop
@section('content')
  <div class="row">
    <div class="span6">
      <div class="login">
        {{ Form::open(array( 'url' => 'login' , 'method' => 'POST' , 'class' => 'form-horizontal')) }}
          <div class="control-group">
            <div class="controls">
             
            </div>
          </div>
          
          <div class="control-group">
            <label for="email" class="control-label">Email </label>
            <div class="controls">
              {{ Form::text( 'email', '',array('placeholder' => 'E-posta', 'id' => 'email1' , 'required' => '') ) }}
            </div>
          </div>
          <div class="control-group">
            <label for="inputPassword" class="control-label">Şifre</label>
            <div class="controls">
              <input type="password" name="password" placeholder="Şifre" required>
            </div>
          </div>
          <div class="control-group">
            <label for="remember" class="control-label">Beni Hatırla</label>
            <div class="controls">
              <div class="pull-left" style="margin-right: 20px;">
              {{ Form::checkbox('remember', 1);}}
              </div>
              {{ Form::button( 'Giriş', array('type' => 'submit', 'class' => 'btn') ) }}
              <a href="#resetPasswordModal" data-toggle="modal" class="btn">Şifremi Unuttum</a>
            </div>
          </div>
          
        {{ Form::close() }}
      </div>
    </div>
    <div class="span6">
      <div class="login">
        {{ Form::open(array( 'url' => 'newuser' , 'method' => 'POST')) }}
          <div class="control-group">
            <div class="controls">
            </div>
          </div>
          <div class="control-group">
            <label for="email" class="control-label">İsim </label>
            <div class="controls">
              {{ Form::text( 'first_name', '',array('placeholder' => 'İsim', 'id' => 'first_name' , 'required' => '') ) }}
            </div>
          </div>
          <div class="control-group">
            <label for="email" class="control-label">Soyisim </label>
            <div class="controls">
              {{ Form::text( 'last_name', '',array('placeholder' => 'Soyisim', 'id' => 'last_name' , 'required' => '') ) }}
            </div>
          </div>
          <div class="control-group">
            <label for="email" class="control-label">Email </label>
            <div class="controls">
              {{ Form::text( 'email', '',array('placeholder' => 'E-posta', 'id' => 'email1' , 'required' => '') ) }}
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
        {{ Form::close() }}
      </div>
    </div>
  </div>
  </div>
<div id="resetPasswordModal" class="modal hide fade">
    <div class="modal-header">
      <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
      <h3>Yeni Şifre Talebi</h3>
    </div>
    <div class="modal-body">
      {{ Form::open(array('url' => 'newuser/reset-password' , 'method' => 'post' , 'id' => 'newPasswordForm' , 'class' => 'form-horizontal' ))}}

        <div class="control-group">
          <label for="email" class="control-label">E-mail </label>
          <div class="controls">
            {{  Form::text('email_reset','',array('placeholder' => 'E-mail' , 'required' => ''))  }}
          </div>
        </div>
      {{  Form::close() }}
    </div>
    <div class="modal-footer"><a href="#" data-dismiss="modal" class="btn">İptal</a>
      {{  Form::submit('Evet', array('class' =>'btn btn-primary' , 'form' => 'newPasswordForm' ))}}
    </div>
  </div> 
@stop