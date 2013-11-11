<!doctype html>
<html>
<head>
	<title>
		  Site | @yield('title')
	</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/bootstrap-responsive.min.css')}}">
	@yield('headerStyles')
	@yield('headerPluginStyles')
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
	<script>
		var localJquery = "{{URL::asset("assets/js/jquery-1.10.0.min.js")}}";
		window.jQuery || document.write('<script src="' + localJquery + '">\x3C/script>')
	</script>
	@yield('headerPluginScripts')
	@yield('headerScripts')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/main.css')}}">
</head>
<body>
	<!-- NAVBAR -->

	<div class="container">
	    <div class="row" style="padding-top:20px;padding-bottom:10px;">
	      <div class="span6">
	        <a href="{{URL::to(Request::root())}}"><img src="http://placehold.it/200x50"></a>
	      </div>
	      <div class="span6">
	        <!--div class="pull-right" style="vertical-align: baseline;">
	          {{Form::open(array('url' => 'product/search' , 'method' => 'get', 'class' => 'form-search', 'style' => 'margin-left: 0; padding-left: 0; margin-bottom:0px;', 'id' => "searchForm"))}}
	          <div class="input-append">
	            {{Form::text('q' , Input::get('query') , array('placeholder' => 'Herhangi bir şeyi ara..', 'data-provide' => 'typeahead' , 'class' => 'typeahead' , 'id' => 'search', 'autocomplete' => 'off', 'class' => 'span2 search-query'))}}
	            {{Form::button('<i class="icon-search"></i>' , array('type' => 'submit', 'class' => 'btn'))}}
	          </div>
	          {{Form::close()}}
	          <br>
	        </div!-->
	      </div>
	    </div>

	    <div class="navbar">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <div class="nav-collapse collapse navbar-responsive-collapse">
	            <ul class="nav">
	              <li @if(Request::segment(1)=='') class="active" @endif><a href="{{URL::to(Request::root())}}"><i class="icon-home"></i>Anasayfa</a></li>
	              <li  @if(Request::segment(1)=='about-us') class="active" @endif><a href="{{URL::to('about-us')}}">Hakkımızda</a></li>
	              <li @if(Request::segment(1)=='corparate') class="active" @endif><a href="{{URL::to('corparate')}}">Kurumsal</a></li>
	              <li @if(Request::segment(1)=='contact') class="active" @endif><a href="{{URL::to('contact')}}">İletişim</a></li>
	            </ul>
	            

	            <ul class="nav pull-right">
	              @if(!Sentry::check())
	                <li @if(Request::segment(1)=='login') class="active" @endif><a href="{{URL::to('login')}}">Giriş Yap</a></li>
	                <li @if(Request::segment(1)=='newuser') class="active" @endif><a href="{{URL::to('newuser')}}">Üye Ol</a></li>
	                <!--li class="divider-vertical"></li-->
	              @else
	                @if (Sentry::getGroups()[0]->name=='Customer')
	                  <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hesabım <b class="caret"></b></a>
	                    <ul class="dropdown-menu">
	                      <li><a href="{{URL::to('account/profile')}}">Profilim</a></li>
	                      <li><a href="{{URL::to('account/profile#orders')}}">Siparişlerim</a></li>
	                      <li class="divider"></li>
	                      <li><a href="{{URL::to('logout')}}">Çıkış</a></li>
	                    </ul>
	                  </li>
	                @else
	                <li><a href="{{URL::to('dashboard')}}">Panele Gir</a></li>
	                @endif
	                @if(Session::has('adminLoginId'))
	                  <li><a href="{{URL::to('force-logout')}}"><i class="icon-eye-close" style="position: relative;top: 2px;"></i> Geri Dön</a></li>
	                @endif
	              @endif
	            </ul>
	          </div><!-- /.nav-collapse -->
	        </div>
	      </div><!-- /navbar-inner -->
	    </div>
  	</div>
	<!-- END NAVBAR -->
	<div class="container">

		@yield('content')
		<?php 
		/*  @TODO
		*	Sayfanın alt kısmında fixed konumda profiler olduğundan 
		*  sayfa altı bozulmakta şimdilik <br> koyuyoruz.
		*/ ?>
		<br>
		<br>
		<br>
		<br>
	</div>
	
	<script type="text/javascript" src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>

	@yield('footerScripts')
	
	<script type="text/javascript">
	$(document).ready(function () {
		$("a").tooltip({
			'selector': '',
			'placement': 'bottom'
		});


		@yield('footerJqueries')
	});
    
    </script>
</body>
</html>