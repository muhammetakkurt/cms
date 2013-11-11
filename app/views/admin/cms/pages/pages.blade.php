@extends('layouts.admin')
@section('title')
	Sayfalar
@stop
@section('search')
	  {{Form::open(array('url' => 'cms-pages/search' , 'method' => 'get', 'class' => 'form-search', 'style' => 'margin-left: 0; padding-left: 0; margin-bottom:0px;'))}}
	  <div class="input-append">
	    {{Form::text('q' , Input::get('search') , array('placeholder' => 'Sayfa Adı', 'data-provide' => 'typeahead' , 'class' => 'typeahead' , 'id' => 'search', 'autocomplete' => 'off', 'class' => 'span2 search-query'))}}
	    {{Form::button('<i class="icon-search"></i>' , array('type' => 'submit', 'class' => 'btn'))}}
	  </div>
	  {{Form::close()}}
@stop
@section('content')
<?php $stickyPages = array(1,2,3,4,5,6,7,8); ?>
<div class="row">
    	<div class="span12" style="padding-top: 0; margin-top: 0;">
			<legend>Sayfalar</legend>
			<div class="pull-right" style="margin-top: -60px;">
			  	<div class="btn-group pull-right">
		    		<a href="{{URL::to('cms-pages/create')}}" class="btn">Yeni Sayfa</a>
		    		@if(count($pages)>8)
						<a href="#checkedDelete" data-toggle="modal" class="btn btn-danger">Sil</a>
					@endif
	  			</div>
			</div>
		</div>
		<div class="span12" style="padding-top: 0; margin-top: 0;">
			{{Form::open(array('url' => 'cms-pages/delete-selected' , 'method' => 'post', 'id' => 'form'))}}
	 		{{Form::close()}}
	 		<table  class="table table-striped sortable">
	 		<thead>
		    	<tr>
		    		<th width="1">
		    			@if(count($pages) > 8)
		    				<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
		    			@endif
		    		</th>
		    		<th>Sayfa Başlık</th>
		    		<th>Yayınlanma Tarihi</th>
		    		<th>Yayından Kaldırma Tarihi</th>
		    		<th>Sıralama</th>
		    		<th>İşlemler</th>
		    		<th class="butontd"></th>
		    		<th class="butontd"></th>
		    	</tr>
	    	</thead>
	    	<?php  $i=1; ?> 
	    	<input type="hidden" name="silinecek_deger" id="silinecek_deger" value="">

	    	@if(count($pages)>0)
	    	<tbody>
    			@foreach ($pages as $page)
	    			<tr>
	    				<td>
	    					@if(!in_array($page->id, $stickyPages))
	    						<input type="checkbox" name="selected[]" value="{{$page->id}}" form="form">
	    					@endif
	    				</td>
	    				<td>
	    					<a href="{{URL::to('cms-pages/'.$page->id.'/edit')}}" rel="tooltip" title="Detay">
	    						{{$page->name}}
	    					</a>
	    				</td>
	    				<td>{{ date("d.m.Y", strtotime($page->published_on)) }}</td>
	    				<td>@if($page->published_off == "") <i>Bulunmuyor</i> @else {{date("d.m.Y", strtotime($page->published_off))}}  @endif</td>
	    				<td>
	    					{{$page->sort_order}}
	    				</td>
	    				<td>
				    		<a href="{{URL::to('cms-pages/'.$page->id.'/edit')}}" class="icon-pencil" rel="tooltip" title="Düzenle">&nbsp;</a>
				    	</td>
				    	<td>
	    					@if(!in_array($page->id, $stickyPages))
			    			{{ Form::open(array('url' => 'cms-pages/'.$page->id, 'method' => 'DELETE' , 'style' => 'margin:0;display: inline;' , 'name' => 'silform'.$i , 'id' => 'silform'.$i )) }}
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
					echo $pages->appends(array('q' => $getSearch))->links();	
				}
				else
				{
					echo $pages->links();	
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
	    <p>Seçtiğiniz sayfalar silinecek devam edilsin mi?</p>
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
	    <p>Seçtiğiniz sayfa silinecek devam edilsin mi?</p>
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
	        return $.getJSON('{{URL::to("ajaxcms/cms-pages-search")}}', {query: query}, function (data) {
	            $.each(data, function(i, object) {
					map[object.name] = object;
		        	objects.push(object.name);
		        });
	        	process(objects);
	        });
	    },
	    updater: function(item) {
	    	location.href='{{URL::to('cms-pages')}}/'+map[item].id+'/edit';
	    }
	});
@stop