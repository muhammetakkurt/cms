@extends('layouts.admin')
@section('title')
	Makale Yorumları
@stop
@section('content')
	<div class="row">
		<div class="span12">
			<legend>Yorumlar</legend>	
			<div class="pull-right" style="margin-top: -60px;">
			 	<a href="#newArticleCommentModal" data-toggle="modal" class="btn">Ekle</a>
	    		@if(count($cmsArticleComments)>0)
					<a href="#checkedDelete" data-toggle="modal" class="btn btn-danger">Sil</a>
				@endif
			</div>
			{{Form::open(array('url' => 'cms-article-comments/delete-selected' , 'method' => 'post', 'id' => 'form'))}}
	 		{{Form::close()}}
	 		<table  class="table table-striped sortable">
		 		<thead>
			    	<tr>
			    		<th width="1">
			    			@if(count($cmsArticleComments)>0)
			    				<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
			    			@endif
			    		</th>
			    		<th>Makale</th>
			    		<th>Yazar</th>
			    		<th>Durum</th>
			    		<th>Oluşturma Tarihi</th>
			    		<th>Güncelleme Tarihi</th>
			    		<th class="butontd"></th>
			    		<th class="butontd"></th>
			    	</tr>
		    	</thead>
		    	<?php  $i=1; ?> 

		    	@if(count($cmsArticleComments)>0)
		    	<input type="hidden" name="silinecek_deger" id="silinecek_deger" value="">
		    	<tbody>
	    			@foreach ($cmsArticleComments as $articleComment)
		    			<tr>
		    				<td>
		    					<input type="checkbox" name="selected[]" value="{{$articleComment->id}}" form="form">
		    				</td>
			    			<td>
			    				<a href="{{URL::to('cms-article-comments/'.$articleComment->id.'/edit')}}"  rel="tooltip" title="Detay">
			    					{{ $articleComment->article->title}}
			    				</a>
			    			</td>
			    			<td>
			    				@if( !is_null($articleComment->author_id) )
			    					{{ $articleComment->user->first_name . ' ' .  $articleComment->user->last_name }}
				    			@else
				    				{{ $articleComment->author_name}}
			    				@endif
			    			</td>
			    			<td>
			    				@if($articleComment->status==1)
			    					Yayında
			    				@else
			    					Yayında değil
			    				@endif
			    			</td>
			    			<td>
			    				{{ $articleComment->created_at}}
			    			</td>
			    			<td>
			    				{{ $articleComment->updated_at}}
			    			</td>
					    	<td>
					    		<a href="{{URL::to('cms-article-comments/'.$articleComment->id.'/edit')}}" class="icon-pencil" rel="tooltip" title="Düzenle">&nbsp;</a>
					    	</td>
					    	<td>
				    			{{ Form::open(array('url' => 'cms-article-comments/'.$articleComment->id, 'method' => 'DELETE' , 'style' => 'margin:0;display: inline;' , 'name' => 'silform'.$i , 'id' => 'silform'.$i )) }}
				    			<a href="#myModal"  data-toggle="modal" onclick="$('#silinecek_deger').val({{$i}})" class="icon-trash" rel="tooltip" title="Sil">&nbsp;</a>
								{{ Form::close() }}
				    		</td>
		    			</tr>
					<?php $i++; ?>	
		    		@endforeach
		    	</tbody>
		    	@else
		    		<tr>
		    			<td colspan="9">
		    				Henüz yorum bulunmamakta.
		    			</td> 
		    		</tr>
	    		@endif
			</table>
			<div class="row text-center">
				{{$cmsArticleComments->links()}}
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
	    <p>Seçtiğiniz yorumlar silinecek devam edilsin mi?</p>
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
	    <p>Seçtiğiniz yorum silinecek devam edilsin mi?</p>
	  </div>
	  <div class="modal-footer">
	  	<button class="btn" data-dismiss="modal">Hayır</button>
	    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick="$('#silform'+$('#silinecek_deger').val()).submit();">Evet</button>
	  </div>
	</div>	


	<div id="newArticleCommentModal" class="modal hide fade">
	  <div class="modal-header">
	    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	    <h3>Yeni Makale Yorumu</h3>
	  </div>
	  <div class="modal-body">
	  	{{	Form::open(array('url' => 'cms-article-comments' , 'method' => 'post', 'id' => 'newArticleCommentForm', 'class' => 'form-horizontal'))	}}	

	      <div class="control-group">
	        <label for="author_name" class="control-label">Yazar Adı </label>
	        <div class="controls">
	         	{{	Form::text('author_name','',array('placeholder' => 'Değer', 'required' => '' , 'id' => 'author_name')) }}
	        </div>
	      </div>

	      <div class="control-group">
	        <label for="product" class="control-label">Makale </label>
	        <div class="controls">
	        	{{Form::text('q' , Input::get('search') , array('placeholder' => 'Aramak için yazmaya başlayın...', 'data-provide' => 'typeahead' , 'class' => 'typeahead form-horizontal' , 'id' => 'ArticleSearch', 'autocomplete' => 'off'))}}
			    <div id="selected_product_container" class="alert alert-success span2" style="margin: 0; display: none;">
    				<button class="close" onClick="toggleArticleSearch(0)" type="button">×</button>
    				<span id="selected_article_title"></span>
    				{{ Form::hidden('article_id', '', array('id' => 'article_id'))}}
    			</div>
	        </div>
	      </div>
	  	 
	  	  <div class="control-group">
	        <label for="status" class="control-label">Yayınla ? </label>
	        <div class="controls">
	         	 {{	Form::checkbox('status', '1', false)}}
	        </div>
	      </div>
	      
	  	  <div class="control-group">
	        <label for="comment" class="control-label">Yorum </label>
	        <div class="controls">
	         	 {{	Form::textarea('comment', '' , array('required' => '' , 'placeholder' => 'Yorum' , 'style' => 'width:80%' , 'rows' => '5'))}}
	        </div>
	      </div>
	     {{ 	Form::close() }}
	  </div>
	  <div class="modal-footer"><a href="#" data-dismiss="modal" class="btn">İptal</a>
	  	{{	Form::submit('Ekle', array('class' =>'btn btn-primary' , 'form' => 'newArticleCommentForm' ))}}
	  </div>
	</div>	
@stop
@section('footerScripts')

	<script type="text/javascript">
		function toggleArticleSearch(requestType)
		{
			if(requestType == 0)
			{
				$( '#article_id' ).val();
			}
			else
			{
				 // Pass
			}
	    	$( '#selected_product_container' ).toggle();
	    	$( '#ArticleSearch' ).toggle();
		}
	</script>
	
@stop
@section('footerJqueries')

	$('#ArticleSearch').typeahead({
	source: function(query, process) {
	    objects = [];
	    map = {};
	    return $.getJSON('{{URL::to("ajaxcms/article-search")}}', {query: query}, function (data) {
	        $.each(data, function(i, object) {
				map[object.title] = object;
		    	objects.push(object.title);
		    });
	    	process(objects);
	    });
	},
	updater: function(item) {
	    var user_id = map[item].id;
	    $.getJSON('{{URL::to('ajaxcms/article-by-id')}}', {query: user_id}, function(data){}).
	    done(function(data){
	    	$( '#article_id' ).val(data.id);
	    	$( '#selected_article_title' ).html(data.title);
	    	toggleArticleSearch(1);
	    });
	},
	minLength: 3
	});

	$('#product').typeahead({
	    source: function (query, process) {
	   		return $.getJSON('{{URL::to("ajaxcms/articles")}}', {query: query}, function (data) {
	   			return process(data);
	   		});
	    }
	});
@stop