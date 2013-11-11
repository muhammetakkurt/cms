@extends('layouts.admin')
@section('content')
<div class="span12 header">
  <h4>Şifre Değişikliği</h4>
</div>
<div class="span6">
	{{ Form::open(array('url' => 'profile/change-password' , 'method' => 'post' , 'class' => 'form-horizontal')) }}
	<div class="control-group">
      <label for="password" class="control-label">Mevcut Şifre </label>
      <div class="controls">
        <input id="password" name="password" type="password" placeholder="Mevcut Şifre" required />
      </div>
    </div>
    <div class="control-group">
      <label for="newpassword" class="control-label">Yeni Şifre </label>
      <div class="controls">
        <input id="newpassword" name="newpassword" type="password" placeholder="Şifre" required/>
      </div>
    </div>
    <div class="control-group">
      <label for="newpasswordagain" class="control-label">Yeni Şifre Tekrar</label>
      <div class="controls">
        <input id="newpasswordagain" name="newpasswordagain" type="password" placeholder="Yeni Şifre Tekrar" />
      </div>
    </div>
    <div class="control-group"> 
      <div class="controls">
        <button type="submit" class="btn">Kaydet</button>
      </div>
    </div>
  {{ Form::close()}}
  </div>
@stop

