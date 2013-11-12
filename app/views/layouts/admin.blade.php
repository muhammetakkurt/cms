<!doctype html>
<html>
<head>
  <title>
    Admin | @yield('title')
  </title>
  <meta charset="utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="">
  <meta name="author" content="" />

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,800italic,400,600,800" type="text/css">
  <link rel="stylesheet" href="{{URL::asset('canvas/css/font-awesome.min.css')}}" type="text/css" />   
  <link rel="stylesheet" href="{{URL::asset('canvas/css/bootstrap.min.css')}}" type="text/css" />  
  <link rel="stylesheet" href="{{URL::asset('canvas/js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.css')}}" type="text/css" />    

  <link rel="stylesheet" href="{{URL::asset('canvas/css/App.css')}}" type="text/css" />

  <link rel="stylesheet" href="{{URL::asset('canvas/css/custom.css')}}" type="text/css" />

  <link rel="stylesheet" href="{{URL::asset('canvas/css/canvas.css')}}" type="text/css" />

  @yield('headerStyles')
  @yield('headerPluginStyles')
  <script src="{{URL::asset('canvas/js/libs/jquery-1.9.1.min.js')}}"></script>

  @yield('headerPluginScripts')
  @yield('headerScripts')
  <script src="{{URL::asset('canvas/js/libs/bootstrap3-typeahead.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/main.css')}}">

</head>
<body>
<div id="wrapper">
  
  <header id="header">

    <h1 id="site-logo">
      <a href="{{URL::to('dashboard')}}">
        <img src="{{URL::asset('canvas/img/logos/logo.png')}}" alt="Site Logo" />
      </a>
    </h1> 

    <a href="javascript:;" data-toggle="collapse" data-target=".top-bar-collapse" id="top-bar-toggle" class="navbar-toggle collapsed">
      <i class="fa fa-cog"></i>
    </a>

    <a href="javascript:;" data-toggle="collapse" data-target=".sidebar-collapse" id="sidebar-toggle" class="navbar-toggle collapsed">
      <i class="fa fa-reorder"></i>
    </a>

  </header> <!-- header -->


  <nav id="top-bar" class="collapse top-bar-collapse">

    <!--ul class="nav navbar-nav pull-left">
      <li class="">
        <a href="{{URL::to('dashboard')}}">
          <i class="fa fa-home"></i> 
          Home
        </a>
      </li>

      <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
              Dropdown <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;"><i class="fa fa-user"></i>&nbsp;&nbsp;Example #1</a></li>
              <li><a href="javascript:;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;Example #2</a></li>
              <li class="divider"></li>
              <li><a href="javascript:;"><i class="fa fa-tasks"></i>&nbsp;&nbsp;Example #3</a></li>
          </ul>
        </li>
        
    </ul-->

    <ul class="nav navbar-nav pull-right">
      @if(Session::has('adminLoginId'))
       <li>
          <a href="{{URL::to('force-logout')}}"><i class="icon-eye-close" style="position: relative;top: 2px;"></i> Geri Dön</a>
        </li>
      @endif
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
          <i class="fa fa-user"></i>
              {{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}
              <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
              <li>
                <a href="{{URL::to('profile')}}">
                  <i class="fa fa-user"></i> 
                  &nbsp;&nbsp;Profilim
                </a>
              </li>
              <li>
                <a href="{{URL::to('profile/change-password')}}">
                  <i class="fa fa-cogs"></i> 
                  &nbsp;&nbsp;Şifre İşlemleri
                </a>
              </li>
              
              <li class="divider"></li>
              <li>
                <a href="{{URL::to('logout')}}">
                  <i class="fa fa-sign-out"></i> 
                  &nbsp;&nbsp;Çıkış
                </a>
              </li>
          </ul>
        </li>
    </ul>

  </nav> <!-- /#top-bar -->


  <div id="sidebar-wrapper" class="collapse sidebar-collapse">
  
    <div id="search-div">
      <form style="display: none;">
        <input class="form-control input-sm" type="text" name="search" id="menu-search" placeholder="   Ara"  data-provide="typeahead" autocomplete="off"/>

        <button type="submit" id="search-btn" class="btn"><i class="fa fa-search"></i></button>
      </form>   
    </div> <!-- #search -->
  
    <nav id="sidebar">    
      
      <ul id="main-nav" class="open-active">      

        <li class="">       
          <a href="{{URL::to('dashboard')}}">
            <i class="fa fa-dashboard"></i>
            Dashboard
          </a>        
        </li>

        <li class="dropdown @if(Request::segment(1)=='cms-pages' or Request::segment(1)=='cms-articles' or Request::segment(1)=='cms-article-comments' or Request::segment(1)=='file-manager' ) active @endif">
          <a href="javascript:;">
            <i class="fa fa-desktop"></i>
            İçerik Yönetimi
            <span class="caret"></span>
          </a>  

          <ul class="sub-nav">
            <li>
              <a href="{{URL::to('cms-pages')}}">
                <i class="fa fa-file"></i>
                Sayfalar
              </a>
            </li>
            <li>
              <a href="{{URL::to('cms-articles')}}">
                <i class="fa fa-reorder"></i>
                Makaleler
              </a>
            </li>
            <li>
              <a href="{{URL::to('cms-article-comments')}}">
                <i class="fa fa-asterisk"></i>
                Makale Yorumları
              </a>
            </li> 
            <li>
              <a href="{{URL::to('file-manager')}}">
                <i class="fa fa-tasks"></i>
                Dosya Yöneticisi
              </a>
            </li> 
          </ul>
        </li>
        <li class="dropdown @if(Request::segment(1)=='users' or Request::segment(1)=='users-groups' ) active @endif">
          <a href="javascript:;">
            <i class="fa fa-table"></i>
            Kullanıcılar
            <span class="caret"></span>
          </a>
          
          <ul class="sub-nav">
            <li>
              <a href="{{URL::to('users')}}">
                <i class="fa fa-user"></i> 
                Kullanıcılar
              </a>
            </li>   
            <li>
              <a href="{{URL::to('users-groups')}}">
                <i class="fa fa-table"></i> 
                Kullanıcı Grupları
              </a>
            </li>
          </ul> 
                  
        </li>
       
      </ul>
          
    </nav> <!-- #sidebar -->

  </div> <!-- /#sidebar-wrapper -->

  <div id="content">
    <div id="content-header">
      <h1>
        @yield('title')
      </h1>
    </div> <!-- #content-header --> 


    <div id="content-container">

      @if(!isset($error_page))
        @include('plugins.breadcrumb')
        @include('plugins.status')
        @include('plugins.requiredControl')
      @endif
      
      @yield('content')
    </div> 
    <?php 
    /*  @TODO
    * Sayfanın alt kısmında fixed konumda profiler olduğundan 
    *  sayfa altı bozulmakta şimdilik <br> koyuyoruz.
    */ ?>
  </div>
  
  <?php /*
  <div id="content">    
    
    <div id="content-header">
      <h1>Blank Page</h1>
    </div> <!-- #content-header --> 


    <div id="content-container">


      

      


      
    </div> <!-- /#content-container -->     
    
  </div> <!-- #content -->
  */ ?>
  
</div> <!-- #wrapper -->

  


<footer id="footer">
  <ul class="nav pull-right">
    <li>
      Copyright &copy; 2013, Jumpstart Themes.
    </li>
  </ul>
</footer>


<script src="{{URL::asset('canvas/js/libs/jquery-ui-1.9.2.custom.min.js')}}"></script>
<script src="{{URL::asset('canvas/js/libs/bootstrap.min.js')}}"></script>

<script src="{{URL::asset('canvas/js/App.js')}}"></script>


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