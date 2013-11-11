@if(Request::segment(1)!='dashboard' && Request::segment(2) != 'login')
<?php $helpers = new Helpers(); ?>
<ul class="breadcrumb">
  <li>
    <a href="{{URL::to('dashboard')}}">
      Anasayfa
    </a> 
    <span class="divider">/</span>
  </li>

  @if(!is_null(Request::segment(2)))
  	<li>
      <a href="{{URL::to(Request::segment(1))}}">
        @foreach($helpers->urls() as $url)
          @if(Request::segment(1)==$url['link'])
            {{ $url['name']}}
          @endif
        @endforeach
      </a> 
    <span class="divider">/</span>
    </li>
  
  @else
  @endif
  
    <li class="active">
    	@if(Request::segment(2)=='create')
    	 Yeni
    	@elseif(Request::segment(3)=='edit')
        Düzenleme
      @elseif(!is_null(Request::segment(2)))
        @if(Request::segment(2)=='change-password')
          Şifre Değişikliği
        @else
          @if(Request::segment(2)=='search')
            Arama
          @else
            Detay
          @endif
        @endif
      @else
          @foreach($helpers->urls() as $url)
            @if(Request::segment(1)==$url['link'])
              {{ $url['name']}}
            @endif
          @endforeach
      @endif
    </li>
</ul>
<div class="row">
  <div class="offset8 span4" style="margin-top: -53px;">
    <div class="pull-right">
      @yield('search')
    </div>
  </div>
</div>
@endif