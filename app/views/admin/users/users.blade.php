@extends('layouts.admin')
@section('title')
	Kullanıcılar
@stop
@section('search')
	  {{Form::open(array('url' => 'users/search' , 'method' => 'get', 'class' => 'form-search', 'style' => 'margin-left: 0; padding-left: 0; margin-bottom:0px;'))}}
	  <div class="input-append">
	    {{Form::text('q' , Input::get('search') , array('placeholder' => 'Kullanıcı Adı', 'data-provide' => 'typeahead' , 'class' => 'typeahead' , 'id' => 'search', 'autocomplete' => 'off', 'class' => 'span2 search-query'))}}
	    {{Form::button('<i class="icon-search"></i>' , array('type' => 'submit', 'class' => 'btn'))}}
	  </div>
	  {{Form::close()}}
@stop
@section('content')
	<div class="row">
	    <div class="span12">
	    	<legend>Kullanıcılar</legend>
			<div class="pull-right" style="margin-top: -60px;">
				<div class="btn-group">
		    		<a href="#newUserModal" data-toggle="modal" class="btn pull-right">Yeni Kullanıcı</a>
	    		</div>
		  	</div>
	    	
		    <table class="table table-striped sortable">
		        <thead>
		          <tr>
		            <th>Ad</th>
		            <th>Soyad</th>
		            <th>Email</th>
		            <th>Grup</th>
		            <th>Durum</th>
		            <th>Son Giriş Tarih</th>
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
				  	<td><a href="{{URL::to('users/'.$user->id)}}" rel="tooltip" title="Kullanıcı detayı">{{ $user->first_name }}</a></td>
		    		<td>{{ $user->last_name }}</td>
		    		<td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
		    		<td>
		    			<?php 
					    $user_group = Sentry::getUserProvider()->findById($user->id);

					    @$group = @$user_group->getGroups();
						?>
		    			@if(@$group[0]['original']['name'])
		    			<a href="{{URL::to('users-groups/'.$group[0]['original']['id'])}}" rel="tooltip" title="Grup detayı">
		    				{{$group[0]['original']['name']}}
		    			</a>
		    			@endif
		    		</td>
		    		<td>
		    			@if($user->activated==1)
		    				Aktif
		    			@else
		    				Aktif Değil
		    			@endif
		    		</td>
		    		<td>{{ $user->last_login }}</td>
		    		<td>{{ $user->created_at }}</td>
		    		<td>
		    			<a href="{{URL::to('force-login/'.$user->id)}}"><i class="icon-eye-open"></i></a>
		    		</td>
		    		<td>
		    			<a href="{{URL::to('users/'.$user->id.'/edit')}}" class="icon-pencil" rel="tooltip" title="Düzenle">&nbsp;</a>
		    		</td>
		    		<td>
		    			{{ Form::open(array('url' => 'users/'.$user->id, 'method' => 'DELETE' , 'style' => 'margin:0;display: inline;' , 'name' => 'silform'.$i , 'id' => 'silform'.$i )) }}
		    			<a href="#myModal"  data-toggle="modal" onclick="$('#silinecek_deger').val({{$i}})" class="icon-trash" rel="tooltip" title="Sil">&nbsp;</a>
						{{ Form::close() }}
		    		</td>
		    	  </tr>
			    <?php $i++; ?>	
				@endforeach
				</tbody>
			</table>
			<div class="row text-center">
				<?php 
					$getSearch = Input::get('q');
					if (isset($getSearch))
					{
						echo $users->appends(array('q' => $getSearch))->links();	
					}
					else
					{
						echo $users->links();	
					}
				?>
			</div>
	   </div>
	</div>
	<!-- Modal -->
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

	<div id="newUserModal" class="modal hide fade">
	  <div class="modal-header">
	    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	    <h3>Yeni Kullanıcı</h3>
	  </div>
	  <div class="modal-body">
	    {{	Form::open(array('url' => 'users' , 'method' => 'post' , 'id' => 'newUserForm' , 'class' => 'form-horizontal'))	}}
	      <div class="control-group">
	        <label for="group" class="control-label">Grup </label>
	        <div class="controls">
	          {{	Form::select('group', $groups)	}}
	        </div>
	      </div>
	      <div class="control-group">
	        <label for="first_name" class="control-label">Adı </label>
	        <div class="controls">
	          {{	Form::text('first_name','',array('placeholder' => 'Adı', 'required' => ''))	}}
	        </div>
	      </div>
	      <div class="control-group">
	        <label for="last_name" class="control-label">Soyadı </label>
	        <div class="controls">
	          {{	Form::text('last_name','',array('placeholder' => 'Soyadı', 'required' => ''))	}}
	        </div>
	      </div>
	      
	      <div class="control-group">
	        <label for="email" class="control-label">E-Posta </label>
	        <div class="controls">
	        	<input type="email" name="email" placeholder="E-posta" required>
	        </div>
	      </div>
	      <div class="control-group">
	        <label for="password" class="control-label">Şifre </label>
	        <div class="controls">
	         <input type="password" name="password" placeholder="Şifre" required/>
	        </div>
	      </div>
	     {{ 	Form::close() }}
	  </div>
	  <div class="modal-footer"><a href="#" data-dismiss="modal" class="btn">İptal</a>
	  	{{	Form::submit('Ekle', array('class' =>'btn btn-primary' , 'form' => 'newUserForm' ))}}
	  </div>
	</div>
@stop

@section('footerJqueries')
	$('#search').typeahead({
	    source: function(query, process) {
	        objects = [];
	        map = {};
	        return $.getJSON('{{URL::to("ajaxusers/users-search")}}', {query: query}, function (data) {
	            $.each(data, function(i, object) {
					map[object.name] = object;
		        	objects.push(object.name);
		        });
	        	process(objects);
	        });
	    },
	    updater: function(item) {
	    	location.href='{{URL::to('users')}}/'+map[item].id+'/edit';
	    }
	});
@stop