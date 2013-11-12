@extends('layouts.admin')
@section('title')
  Şifre Değişikliği
@stop
@section('content')
<div class="col-md-12 header">
  <h4>Şifre Değişikliği</h4>
</div>
<div class="col-md-6">
	{{ Form::open(array('url' => 'profile/change-password' , 'method' => 'post' , 'class' => 'form-horizontal')) }}
	<div class="control-group">
      <label for="password" class="control-label">Mevcut Şifre </label>
      <div class="controls">
        <input id="password" name="password" type="password" class="form-control" placeholder="Mevcut Şifre" required />
      </div>
    </div>
    <div class="control-group">
      <label for="newpassword" class="control-label">Yeni Şifre </label>
      <div class="controls">
        <input id="newpassword" name="newpassword" type="password" class="form-control" placeholder="Şifre" required/>
      </div>
    </div>
    <div class="control-group">
      <label for="newpasswordagain" class="control-label">Yeni Şifre Tekrar</label>
      <div class="controls">
        <input id="newpasswordagain" name="newpasswordagain" class="form-control" type="password" placeholder="Yeni Şifre Tekrar" required />
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
@stop

