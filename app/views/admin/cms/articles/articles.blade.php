@extends('layouts.admin')
@section('title')
	Makaleler
@stop
@section('headerStyles')
	<style type="text/css">
		
	</style>
@stop
@section('search')
	  {{Form::open(array('url' => 'cms-articles/search' , 'method' => 'get', 'class' => 'form-search', 'style' => 'margin-left: 0; padding-left: 0; margin-bottom:0px;'))}}
	  <div class="input-append">
	    {{Form::text('q' , Input::get('q') , array('placeholder' => 'Makale Adı', 'data-provide' => 'typeahead' , 'class' => 'typeahead' , 'id' => 'search', 'autocomplete' => 'off', 'class' => 'span2 search-query'))}}
	    {{Form::button('<i class="icon-search"></i>' , array('type' => 'submit', 'class' => 'btn'))}}
	  </div>
	  {{Form::close()}}
@stop
@section('content')
<?php $stickyPages = array(1,2,3,4,5,6); ?>
<div class="row">
    	<div class="span12" style="padding-top: 0; margin-top: 0;">
			<legend>Makaleler</legend>
			<div class="pull-right" style="margin-top: -60px;">
			  	<div class="btn-group pull-right">
		    		<a href="{{URL::to('cms-articles/create')}}" class="btn">Yeni Makale</a>
		    		@if(count($articles)>6)
						<a href="#checkedDelete" data-toggle="modal" class="btn btn-danger">Sil</a>
					@endif
	  			</div>
			</div>
		</div>
		<div class="span12" style="padding-top: 0; margin-top: 0;">
			{{Form::open(array('url' => 'cms-articles/delete-selected' , 'method' => 'post', 'id' => 'form'))}}
	 		{{Form::close()}}
	 		<table  class="table table-striped sortable">
	 		<thead>
		    	<tr>
		    		<th width="1">
		    			@if(count($articles) > 6)
		    				<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
		    			@endif
		    		</th>
		    		<th>Makale Başlık</th>
		    		<th>Yayın Tarihi</th>
		    		<th>Yayından Kaldırma Tarihi</th>
		    		<th class="butontd"></th>
		    		<th class="butontd"></th>
		    	</tr>
	    	</thead>
	    	<?php  $i=1; ?> 
	    	<input type="hidden" name="silinecek_deger" id="silinecek_deger" value="">

	    	@if(count($articles)>0)
	    	<tbody>
    			@foreach ($articles as $article)
	    			<tr>
	    				<td>
	    					@if(!in_array($article->id, $stickyPages))
	    						<input type="checkbox" name="selected[]" value="{{$article->id}}" form="form">
	    					@endif	
	    				</td>
	    				<td>
	    					<a href="{{URL::to('cms-articles/'.$article->id.'/edit')}}" rel="tooltip" title="Detay">
	    						{{$article->title}}
	    					</a>
	    				</td>
	    				<td>{{ date("d.m.Y", strtotime($article->published_on)) }}</td>
	    				<td>@if($article->published_off == "") Bulunmamaktadır @else {{ date("d.m.Y", strtotime($article->published_off)) }} @endif</td>
	    				<td>
				    		<a href="{{URL::to('cms-articles/'.$article->id.'/edit')}}" class="icon-pencil" rel="tooltip" title="Düzenle">&nbsp;</a>
				    	</td>
				    	<td>
				    		@if(!in_array($article->id, $stickyPages))
				    			{{ Form::open(array('url' => 'cms-articles/'.$article->id, 'method' => 'DELETE' , 'style' => 'margin:0;display: inline;' , 'name' => 'silform'.$i , 'id' => 'silform'.$i )) }}
				    			<a href="#myModal"  data-toggle="modal" onclick="$('#silinecek_deger').val({{$i}})" class="icon-trash" rel="tooltip" title="Sil">&nbsp;</a>
								{{ Form::close() }}
							@endif
			    		</td>
	    			</tr>
				<?php $i++; ?>	
	    		@endforeach
	    	</tbody>
	    	@else
	    		<tr>
	    			<td colspan="12">
	    				Henüz sayfa bulunmamakta.
	    			</td> 
	    		</tr>
    		@endif
		</table>
		<div class="row text-center">
			<?php 
				$getSearch = Input::get('q');
				if (isset($getSearch))
				{
					echo $articles->appends(array('q' => $getSearch))->links();	
				}
				else
				{
					echo $articles->links();	
				}
			?>
		</div>
	</div>
</div>
	
	<!-- Modal -->
	<div id="checkedDelete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Onay</h3>
	  </div>
	  <div class="modal-body">
	    <p>Seçtiğiniz makaleler silinecek devam edilsin mi?</p>
	  </div>
	  <div class="modal-footer">
	  	<button class="btn" data-dismiss="modal">Hayır</button>
	    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$('#form').submit();">Evet</button>
	  </div>
	</div>	

	<!-- Modal -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Onay</h3>
	  </div>
	  <div class="modal-body">
	    <p>Seçtiğiniz makale silinecek devam edilsin mi?</p>
	  </div>
	  <div class="modal-footer">
	  	<button class="btn" data-dismiss="modal">Hayır</button>
	    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$('#silform'+$('#silinecek_deger').val()).submit();">Evet</button>
	  </div>
	</div>	
	
@stop

@section('footerJqueries')
	$('#search').typeahead({
	    source: function(query, process) {
	        objects = [];
	        map = {};
	        return $.getJSON('{{URL::to("ajaxcms/cms-articles-search")}}', {query: query}, function (data) {
	            $.each(data, function(i, object) {
					map[object.name] = object;
		        	objects.push(object.name);
		        });
	        	process(objects);
	        });
	    },
	    updater: function(item) {
	    	location.href='{{URL::to('cms-articles')}}/'+map[item].id+'/edit';
	    }
	});
@stop