<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="description" content="description of your site" />
    <meta name="author" content="author of the site" />
    <title>E-Ticaret Login</title>
    <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.css')}}" />
    
    <style type="text/css">
      .alert{
        width: 170px;
        margin-left: 180px;
      }
    </style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
  <body>
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset2">
            <div class="login">

              {{ Form::open(array( 'url' => 'newuser/new-password/'.Request::segment(3) , 'method' => 'POST' , 'class' => 'form-horizontal')) }}
                <div class="control-group">
                  <div class="controls" style="height:220px;">
                    {{$full_name}}  
                  </div>
                  @include('plugins.status')
                </div>
                
                <div class="control-group">
                  <label for="email" class="control-label">Şifre</label>
                  <div class="controls">
                    <input type="password" name="password" placeholder="Şifre" required> 
                  </div>
                </div>
                <div class="control-group">
                  <label for="inputPassword" class="control-label">Şifre Tekrar</label>
                  <div class="controls">
                    <input type="password" name="passwordr" placeholder="Şifre Tekrar" required> 
                  </div>
                </div>
                <div class="control-group"> 
                  <div class="controls">
                    {{ Form::submit('Kaydet',array('class' => 'btn'))}}
                  </div>
                </div>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </body>
  <script>
    $(document).ready(function () {
      // required (zorunlu) olan inputları döngüye sokup ingilizce metinleri input bilgilerine göre değiştiriyoruz.
      var intputElements = document.getElementsByTagName("INPUT");
        $("input").each(function(i){
            if($(this).attr("required")){
                intputElements[i].oninvalid = function (e) {
                  e.target.setCustomValidity("");
                  if (!e.target.validity.valid) {
              e.target.setCustomValidity("'"+e.target.placeholder+"' alanı gereklidir.");
                  }
              };
            }
        });
      
    });
  </script>
</html>