@extends('layouts.admin')
@section('title')
	Kullanıcı Grupları
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
    	<legend>Kullanıcılar</legend>
    	<div class="pull-right" style="margin-top: -60px;">
			<div class="btn-group">
	    		<a href="#newUserGroupModal" data-toggle="modal" class="btn btn-warning pull-right">Yeni Kullanıcı Grubu</a>
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
	    			<a href="{{URL::to('users-groups/'.$usergroups[$j]['original']['id'])}}"  class="fa fa-search"  rel="tooltip" title="Detay">&nbsp;</a>
	    		</td>
		    	<td>
		    		@if($usergroups[$j]['original']['name']!='Admin')
		    			@if($usergroups[$j]['original']['name']!='Customer')
		    			<a href="{{URL::to('users-groups/'.$usergroups[$j]['original']['id'].'/edit')}}" class="fa fa-pencil" rel="tooltip" title="Düzenle">&nbsp;</a>
		    			@endif
		    		@endif
		    	</td>
	    		<td>
	    			@if( $usergroups[$j]['original']['name']!='Admin')
	    				@if($usergroups[$j]['original']['name']!='Customer')
			    			{{ Form::open(array('url' => 'users-groups/'.$usergroups[$j]['id'], 'method' => 'DELETE' , 'style' => 'margin:0;display: inline;' , 'name' => 'silform'.$i , 'id' => 'silform'.$i )) }}
			    			<a href="#myModal"  data-toggle="modal" onclick="$('#silinecek_deger').val({{$i}})" class="fa fa-times" rel="tooltip" title="Sil">&nbsp;</a>
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
	<div class="modal fade modal-styled" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Onay</h4>
	      </div>
	      <div class="modal-body">
	        <p>Seçtiğiniz kullanıcı grubu silinecek devam edilsin mi?</p>
	      </div>
	      <div class="modal-footer">
		  	<button class="btn" data-dismiss="modal">Hayır</button>
		    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$('#silform'+$('#silinecek_deger').val()).submit();">Evet</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Modal -->
	<div class="modal fade modal-styled" id="newUserGroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Yeni Grup</h4>
	      </div>
	      <div class="modal-body">
		  	{{	Form::open(array('url' => 'users-groups' , 'method' => 'post', 'id' => 'newUserGroupForm', 'class' => 'form-horizontal'))	}}
		      <div class="row">
		        <label for="name" class="control-label col-md-12">Grup Adı </label>
		        <div class="col-md-12">
		         	{{	Form::text('name','',array('placeholder' => 'Grup Adı', 'required' => '' , 'class' => 'form-control')) }}
		        </div>
		      </div>
		    {{ 	Form::close() }}
		  </div>
	      <div class="modal-footer">
			<a href="#" data-dismiss="modal" class="btn btn-warning">İptal</a>
		  	{{	Form::submit('Ekle', array('class' =>'btn btn-primary' , 'form' => 'newUserGroupForm' ))}}
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop