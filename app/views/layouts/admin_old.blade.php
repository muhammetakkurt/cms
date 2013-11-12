<!doctype html>
<html>
<head>
	<title>
		Admin | @yield('title')
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
	<!--nav-->
	<div class="container">
    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{{URL::to('dashboard')}}">CMS</a>
          <div class="nav-collapse collapse navbar-responsive-collapse">
            <ul class="nav">
              
              <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-folder-close icon-white"></i> İçerik Yönetimi <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      @if (Sentry::getUser()->hasAccess('CmsPages'))
                        <li><a href="{{URL::to('cms-pages')}}"><i class="icon-file"></i> Sayfalar</a></li>
                      @endif
                      @if (Sentry::getUser()->hasAccess('CmsArticles'))
                        <li><a href="{{URL::to('cms-articles')}}"><i class="icon-pencil"></i> Makaleler</a></li>
                      @endif
                      @if (Sentry::getUser()->hasAccess('CmsArticleComments'))
                        <li><a href="{{URL::to('cms-article-comments')}}"><i class="icon-pencil"></i> Makale Yorumları</a></li>
                      @endif
                      @if (Sentry::getUser()->hasAccess('FileManager'))
                        <li><a href="{{URL::to('file-manager')}}"><i class="icon-folder-open"></i> Dosya Yöneticisi</a></li>
                      @endif
                    </ul>
                  </li>
              <li class="divider-vertical"></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user icon-white"></i> Kullanıcılar<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  @if (Sentry::getUser()->hasAccess('Users'))
                  <li><a href="{{URL::to('users')}}"><i class="icon-user"></i> Kullanıcılar</a></li>
                  @endif
                  @if (Sentry::getUser()->hasAccess('UserGroups'))
                  <li><a href="{{URL::to('users-groups')}}"><i class="icon-th-list"></i> Kullanıcı Grupları</a></li>
                  @endif
                </ul>
              </li>
            </ul>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-bookmark icon-white"></i> Pano <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li class="nav-header">Profil İşlemleri</li>
                    <li><a href="{{URL::to('profile')}}"><i class="icon-user"></i> Profilim</a></li>
                    <li><a href="{{URL::to('profile/change-password')}}"><i class="icon-lock"></i> Şifre İşlemleri</a></li>
                    <li><a href="{{URL::to('logout')}}"><i class="icon-remove"></i> Çıkış</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Bağlantılar</li>
                    <li>
                      <a href="{{URL::to(Request::root())}}" target="_blank"><i class="icon-globe"></i> Siteye Git</a>
                    </li>
                </ul>
              </li>
            </ul>
          </div><!-- /.nav-collapse -->
        </div>
      </div><!-- /navbar-inner -->
    </div>
	</div>

	<!--end nav-->
	<div class="container">
		@if(!isset($error_page))
			@include('plugins.breadcrumb')
			@include('plugins.status')
			@include('plugins.requiredControl')
		@endif
		
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

		@include('plugins.submitControlJscript')

		@include('plugins.requiredControlJscript')

		@yield('footerJqueries')
	});
    
    </script>
</body>
</html>