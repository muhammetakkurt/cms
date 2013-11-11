@extends('layouts.admin')
@section('title')
  {{$usergroup['name']}} Grup Detayı
@stop
@section('content')

    <div class="row">
        <div class="span12">
            <a href="{{URL::to('users-groups/'.$usergroup['id'].'/edit')}}" class="btn pull-right">Düzenle</a>
            <legend>{{$usergroup['name']}} Grup Detayı</legend>
            <table class="table table-striped sortable">
                <thead>
                  <tr>
                    <th>Ad - Soyad</th>
                    <th>Email</th>
                    <th>Kayıt Tarihi</th>
                    <th class="butontd"></th>
                    <th class="butontd"></th>
                    <th class="butontd"></th>
                  </tr>
                </thead>
                
                <?php  $i=1; ?> 
                <tbody>
                <input type="hidden" name="silinecek_deger" id="silinecek_deger" value="">


                @foreach ($users as $user)
                  <tr>
                    <td><a href="{{URL::to('users/'.$user->user_id.'/edit')}}" rel="tooltip" title="Kullanıcı detayı">{{ $user->full_name }}</a></td>
                    <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>

                    <td>{{ $user->created_at }}</td>
                    <td><a href="{{URL::to('users/'.$user->user_id)}}"  class="icon-search"  rel="tooltip" title="Detay">&nbsp;</a></td>
                        <td><a href="{{URL::to('users/'.$user->user_id.'/edit')}}" class="icon-pencil" rel="tooltip" title="Düzenle">&nbsp;</a>
                        </td>
                        <td>
                            {{ Form::open(array('url' => 'users/'.$user->user_id, 'method' => 'DELETE' , 'style' => 'margin:0;display: inline;' , 'name' => 'silform'.$i , 'id' => 'silform'.$i )) }}
                            <a href="#myModal"  data-toggle="modal" onclick="$('#silinecek_deger').val({{$i}})" class="icon-trash" rel="tooltip" title="Sil">&nbsp;</a>
                            {{ Form::close() }}
                        </td>
                  </tr>
                <?php $i++; ?>  
                @endforeach
                </tbody>
            </table>
       </div>
    </div>

    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Onay</h3>
        </div>
        <div class="modal-body">
          <p>Seçtiğiniz kullanıcı silinecek devam edilsin mi?</p>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal">Hayır</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$('#silform'+$('#silinecek_deger').val()).submit();">Evet</button>
        </div>
      </div>

@stop