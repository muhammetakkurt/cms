<div style="releative">
    <div class="alertbox">
        @if (!is_null(Session::get('status_error')))
            <div class="alert alert-error">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading">Başarısız!</h4>
                @if (is_array(Session::get('status_error')))
                    <ul>
                    @foreach (Session::get('status_error') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                @else
                    {{ Session::get('status_error') }}
                @endif
            </div>
        @endif
        @if (!is_null(Session::get('status_success')))
            <div class="alert alert-success">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading">Başarılı!</h4>
                @if (is_array(Session::get('status_success')))
                    <ul>
                    @foreach (Session::get('status_success') as $success)
                        <li>{{ $success }}</li>
                    @endforeach
                    </ul>
                @else
                    {{ Session::get('status_success') }}
                @endif
            </div>
        @endif
    </div>
</div>
<?php 
Session::forget('status_error');
Session::forget('status_success');
?>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            $(".alertbox .alert").slideToggle('slow'); 
            setTimeout(function()
                {
                    $(".alertbox .alert").alert('close');
                },1000);
        },3000);
    })
</script>