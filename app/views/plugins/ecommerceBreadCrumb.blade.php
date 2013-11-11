@if(Request::segment(1))
<ul class="breadcrumb" >
  <li>
      <a href="{{URL::to(Request::root())}}">Anasayfa</a> 
      <span class="divider">/</span>
  </li>
  @if(Request::segment(1)=='category')
  <li id="category_item">
    <a href="{{URL::to('category')}}">Kategoriler</a> 
    <span class="divider">/</span>
  </li>
    @if(Request::segment(2))
      
    @else
      <li class="active">
        Genel
      </li>
    @endif
  @elseif(Request::segment(1)=='product' and Request::segment(2)=='search' ) 
  <li id="category_item">
    <a href="{{URL::to('product')}}">Ürünler</a> 
    <span class="divider">/</span>
  </li>
  <li class="active">
    Arama
  </li>
  @elseif(Request::segment(1)=='product') 
  <li id="category_item">
    <a href="{{URL::to('category')}}">Kategoriler</a> 
    <span class="divider">/</span>
  </li>
    @if(Request::segment(2))
      
    @else
      <li class="active">
        Ürünler
      </li>
    @endif
  @elseif(Request::segment(1)=='login')
    <li class="active">
        Giriş
    </li>
  @elseif(Request::segment(1)=='newuser')
    <li class="active">
        Kayıt Ol
    </li>
  @elseif(Request::segment(1)=='shopping-cart')
    <li class="active">
        Sepetim
    </li>
  @elseif(Request::segment(1)=='wishlist')
    <li class="active">
        Listem
    </li>
  @elseif(Request::segment(1)=='about-us')
    <li class="active">
        Hakkımızda
    </li>
  @elseif(Request::segment(1)=='contact')
    <li class="active">
        İletişim
    </li>
  @elseif(Request::segment(1)=='corparate')
    <li class="active">
        Kurumsal
    </li>
  @elseif(Request::segment(1)=='order')
    <li>
        <a href="{{URL::to('shopping-cart')}}">Sepetim</a>
    </li>
    <span class="divider">/</span>
    <li class="active">
        Sipariş
    </li>
    @elseif(Request::segment(1)=='account')
    @if(Request::segment(2)!='orders')
    <li class="active">
        Hesabım
    </li>  
    @else
    <li class="active">
      <a href="{{URL::to('account/profile')}}">Hesabım</a> 
      <span class="divider">/</span>
    </li> 
    <li class="active">
        Siparişlerim
    </li> 
    @endif
  @endif
</ul>
@if(Request::segment(1)=='category' and Request::segment(2))
<script type="text/javascript">
  $(document).ready(function () {
    var categoryPointer = 0;
    $.getJSON( '{{ URL::to("ajax/upper-product-categories-by-id") }}', {query: <?php echo $productCategory->id ?>}, function( data ) {
          $( data ).each(function(i, item){
            var html='';
            if (categoryPointer==0)
            {
              html='<li class="active">';
              html+=item.name;
              html+='</li>';  
            }
            else
            {
              html='<li>';
              html+='<a href="{{URL::to("category")}}/'+item.seo_name+'">'+item.name+'</a>';
              html+='<span class="divider">/</span>';
              html+='</li>';  
            }
            $('#category_item').after(html);
            categoryPointer++;
          });
      });
  });
</script>
@elseif(Request::segment(1)=='product' and Request::segment(2) and Request::segment(2)!='search')
<script type="text/javascript">
  $(document).ready(function () {
    var categoryPointer = 0;
    $.getJSON( '{{ URL::to("ajax/upper-product-categories-by-id") }}', {query: <?php echo $lastProductCategory ?>}, function( data ) {
          $( data ).each(function(i, item){
            var html='';
            
            html='<li>';
            html+='<a href="{{URL::to("category")}}/'+item.seo_name+'">'+item.name+'</a>';
            html+='<span class="divider">/</span>';
            html+='</li>';  
            $('#category_item').after(html);
            categoryPointer++;
          });
      });
    html='<li class="active">';
    html+='{{$product->name}}';
    html+='</li>';
    $('#category_item').after(html);
  });
</script>
@endif
@endif