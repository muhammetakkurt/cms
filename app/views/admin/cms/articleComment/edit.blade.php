@extends('layouts.admin')
@section('title')
	Yorum Düzenleme
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<h4>Yorum Düzenleme</h4>
		{{	Form::open(array('url' => 'cms-article-comments/'.$cmsArticleComment->id , 'method' => 'PUT', 'id' => 'newcmsArticleCommentForm'))	}}	

	      <div class="row">
	        <label for="author_name" class="col-md-12">Yazar Adı </label>
	        <div class="col-md-6">
	        	@if(!is_null($cmsArticleComment->author_id))
		         	{{ Form::text('author_name',$cmsArticleComment->user->first_name . ' ' . $cmsArticleComment->user->last_name, array('class' => 'form-control' , 'placeholder' => 'Değer', 'required' => '' , 'id' => 'author_name', 'disabled' => 'disabled')) }}
		         	{{ Form::hidden('author_id', $cmsArticleComment->user->id)}}
		        @else
		         	{{ Form::text('author_name',$cmsArticleComment->author_name,array('class' => 'form-control' ,  'placeholder' => 'Değer', 'required' => '' , 'id' => 'author_name')) }}
		        @endif
	        </div>
	      </div>

	      <div class="row">
	        <label for="product" class="col-md-12">Ürün </label>
	        <div class="col-md-6">
	        	{{Form::text('q' , '', array('placeholder' => 'Aramak için yazmaya başlayın...', 'data-provide' => 'typeahead' , 'class' => 'typeahead form-horizontal' , 'id' => 'articleSearch', 'autocomplete' => 'off', 'style' => 'display: none'))}}
			    <div id="selected_product_container" class="alert alert-success span2" style="margin-right: 0px; margin-left: 0px;">
    				<button class="close" onClick="toggleArticleSearch(0)" type="button">×</button>
    				<span id="selected_article_title">{{$article['title']}}</span>
	         		{{  Form::hidden('article_id', $article['id'], array('id' => 'article_id'))}}
    			</div>
	        </div>
	      </div>
	  	 
	  	  <div class="row">
	        <label for="status" class="col-md-12">Yayınla ? </label>
	        <div class="col-md-6">
	         	 {{	Form::checkbox('status', '1', $cmsArticleComment->status)}}
	        </div>
	      </div>
	      
	  	  <div class="row">
	        <label for="comment" class="col-md-12">Yorum </label>
	        <div class="col-md-6">
	         	 {{	Form::textarea('comment', $cmsArticleComment->comment , array('required' => '' , 'placeholder' => 'Yorum' , 'rows' => '5' , 'class' => 'form-control'))}}
	        </div>
	      </div>
	      {{	Form::submit('Kaydet', array('class' => 'btn btn-primary'))}}
	     {{ 	Form::close() }}
	</div>
</div>
@stop
@section('footerScripts')
	<script>
		function toggleArticleSearch(requestType)
		{
			if(requestType == 0)
			{
				$( '#article_id' ).val('');
			}
			else
			{
				 // Pass
			}
	    	$( '#selected_product_container' ).toggle();
	    	$( '#articleSearch' ).toggle();
		}
	</script>
@stop
@section('footerJqueries')

	$('#articleSearch').typeahead({
	source: function(query, process) {
	    objects = [];
	    map = {};
	    return $.getJSON('{{URL::to("ajax/article-search")}}', {query: query}, function (data) {
	        $.each(data, function(i, object) {
				map[object.title] = object;
		    	objects.push(object.title);
		    });
	    	process(objects);
	    });
	},
	updater: function(item) {
	    var user_id = map[item].id;
	    $.getJSON('{{URL::to('ajax/article-by-id')}}', {query: user_id}, function(data){}).
	    done(function(data){
	    	$( '#article_id' ).val(data.id);
	    	$( '#selected_article_title' ).html(data.title);
	    	toggleArticleSearch(1);
		});
	},
	minLength: 3
	});

@stop