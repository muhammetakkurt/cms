@extends('layouts.admin')
@section('title')
	Kullanıcı Grupları
@stop
@section('content')
<div class="row">
    <div class="span12">
    	<legend>Kullanıcılar</legend>
    	<div class="pull-right" style="margin-top: -60px;">
			<div class="btn-group">
	    		<a href="#newUserGroupModal" data-toggle="modal" class="btn pull-right">Yeni Kullanıcı Grubu</a>
    		</div>
	  	</div>
		
		
	 		<table  class="table table-striped sortable">
	 		<thead>
		    	<tr>
		    		<td>Grup Adı</td>
		    		<td>İzinler</td>
		    		<td class="butontd"></td>
		    		<td class="butontd"></td>
		    		<td class="butontd"></td>
		    	</tr>
	    	</thead>
	    	<?php  $i=1; ?> 
	    	<input type="hidden" name="silinecek_deger" id="silinecek_deger" value="">
	    	
	    	@for($j = 0, $l = count($usergroups); $j < $l; ++$j)
	    	<tbody>
			  <tr>
	    		<td><a href="{{URL::to('users-groups/'.$usergroups[$j]['original']['id'])}}" rel="tooltip" title="Detay">{{ $usergroups[$j]['original']['name'] }}</a></td>
	    		<td>{{ $usergroups[$j]['original']['permissions'] }}</td>
	    		<td>
	    			<a href="{{URL::to('users-groups/'.$usergroups[$j]['original']['id'])}}"  class="icon-search"  rel="tooltip" title="Detay">&nbsp;</a>
	    		</td>
		    	<td>
		    		@if($usergroups[$j]['original']['name']!='Admin')
		    			@if($usergroups[$j]['original']['name']!='Customer')
		    			<a href="{{URL::to('users-groups/'.$usergroups[$j]['original']['id'].'/edit')}}" class="icon-pencil" rel="tooltip" title="Düzenle">&nbsp;</a>
		    			@endif
		    		@endif
		    	</td>
	    		<td>
	    			@if( $usergroups[$j]['original']['name']!='Admin')
	    				@if($usergroups[$j]['original']['name']!='Customer')
			    			{{ Form::open(array('url' => 'users-groups/'.$usergroups[$j]['id'], 'method' => 'DELETE' , 'style' => 'margin:0;display: inline;' , 'name' => 'silform'.$i , 'id' => 'silform'.$i )) }}
			    			<a href="#myModal"  data-toggle="modal" onclick="$('#silinecek_deger').val({{$i}})" class="icon-trash" rel="tooltip" title="Sil">&nbsp;</a>
							{{ Form::close() }}
						@endif
					@endif
	    		</td>
	    	  </tr>
		    <?php $i++; ?>	
			@endfor
			</tbody>
		</table>
	</div>
</div>

	<!-- Modal -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Onay</h3>
	  </div>
	  <div class="modal-body">
	    <p>Seçtiğiniz kullanıcı grubu silinecek devam edilsin mi?</p>
	  </div>
	  <div class="modal-footer">
	  	<button class="btn" data-dismiss="modal">Hayır</button>
	    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$('#silform'+$('#silinecek_deger').val()).submit();">Evet</button>
	  </div>
	</div>	

	<div id="newUserGroupModal" class="modal hide fade">
	  <div class="modal-header">
	    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	    <h3>Yeni Grup</h3>
	  </div>
	  <div class="modal-body">
	  	{{	Form::open(array('url' => 'users-groups' , 'method' => 'post', 'id' => 'newUserGroupForm', 'class' => 'form-horizontal'))	}}
	      <div class="control-group">
	        <label for="name" class="control-label">Grup Adı </label>
	        <div class="controls">
	         	{{	Form::text('name','',array('placeholder' => 'Grup Adı', 'required' => '')) }}
	        </div>
	      </div>
	    {{ 	Form::close() }}
	  </div>
	  <div class="modal-footer"><a href="#" data-dismiss="modal" class="btn">İptal</a>
	  	{{	Form::submit('Ekle', array('class' =>'btn btn-primary' , 'form' => 'newUserGroupForm' ))}}
	  </div>
	</div>	
@stop