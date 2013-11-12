@extends('layouts.admin')
@section('title')
	{{$article->title.' Düzenleme'}}
@stop
@include('plugins.elfinder')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="col-md-3 pull-right text-right">
			<button type="submit" class="btn btn-warning"><i class="icon-ok"></i>&nbsp; Kaydet</button>
		</div>	
		<h4>{{$article->title.' Düzenleme'}}</h4>
	</div>
	{{	Form::open(array('url' => 'cms-articles/'.$article->id , 'method' => 'PUT', 'id' => 'editCmsArticleForm'))	}}
	<div class="col-md-12">
		<div class="tabbable tabs-left">
	      <ul class="nav nav-tabs">
	        <li class="active"><a href="#general" data-toggle="tab">Genel</a></li>
	        <li class=""><a href="#images" data-toggle="tab">Resimler</a></li>
	      </ul>
	      <div class="tab-content">
	        <div class="tab-pane active" id="general">

	         		<div class="control-group">
	         			<div class="row">
         					<div class="col-md-3" style="margin-left: 0px;">
         						<label for="published_on" class="control-label">Yayınlanma Tarihi </label>
	         					<div class="input-append">
								  {{	Form::text('published_on',$article->published_on,array('placeholder' => 'Yayınlanma Tarihi', 'required' => '' , 'id' => 'article_published_on' , 'class' => 'col-md-2 form-control')) }}
								  <span class="add-on"><i class="icon-list-alt"></i></span>
								</div>
							</div>
							<div class="col-md-4">
								<label for="published_off" class="control-label">Yayından Çekme Tarihi </label>
								<div class="input-append">
								  {{	Form::text('published_off',$article->published_off,array('placeholder' => 'Yayından Çekme Tarihi', 'id' => 'article_published_off' , 'class' => 'col-md-2  form-control')) }}
								  <span class="add-on"><i class="icon-list-alt"></i></span>
								</div>
							</div>
	         			</div>
				    </div>
				    <div class="row">
				        <label for="title" class="control-label col-md-12">Sayfa</label>
				        <div class="col-md-3">
				         	{{ Form::select('page_id', $pages, $article->page_id , array('class' => 'form-control'))}}
				        </div>
				    </div>
					<div class="row">
				        <label for="title" class="control-label col-md-12">Makale Başlık </label>
				        <div class="col-md-12">
				         	{{	Form::text('title',$article->title,array('placeholder' => 'Makale Başlık', 'required' => '' , 'class' => 'form-control'))}}
				        </div>
				    </div>

					<div class="row">
				        <label for="summary" class="control-label col-md-12">Özet </label>
				        <div class="col-md-12">
				         	{{	Form::textarea('summary',$article->summary,array('placeholder' => 'İçerik','id' => 'articleSummary'))}}
				        </div>
				    </div>

					<div class="row">
				        <label for="content" class="control-label col-md-12">İçerik </label>
				        <div class="col-md-12">
				         	{{	Form::textarea('content',$article->content,array('placeholder' => 'İçerik','id' => 'articleContent'))}}
				        </div>
				    </div>
				
	        </div>
	        <div class="tab-pane" id="images">
	        	<table class="table table-striped">
	        		<thead>
	        			<tr>
	        				<th>Resim</th>
	        				<th>Sıralama</th>
	        				<td></td>
	        			</tr>
	        		</thead>
        			<tbody>
        				<?php $image_row = 0 ; ?>
						@foreach($article->medias as $media)
        					<tr id="image-row{{$image_row}}">
								<td class="centered">
									<input type="hidden" name="medias[{{$image_row}}][id]" value="{{$media->id}}" id="image{{$image_row}}_id" />
									<input type="hidden" name="medias[{{$image_row}}][name]" value="{{$media->name}}" id="image{{$image_row}}" />
									<input type="hidden" name="medias[{{$image_row}}][path]" value="{{$media->path}}" id="image{{$image_row}}_path" />
									<input type="hidden" name="medias[{{$image_row}}][base_url]" value="" id="image{{$image_row}}_base_url" />
									<img src="<?php echo Request::root().'/assets/thumbnail.php?src='.$media->path?>" alt="" id="preview{{$image_row}}" class="image" onclick="image_upload('image{{$image_row}}','preview{{$image_row}}');" />
								</td>
								<td class="centered">
									<input type="text" name="medias[{{$image_row}}][sort_order]" class="col-md-2 local-form-control text-right" value="{{$media->pivot->sort_order}}" />
								</td>			
								<td class="centered">
									<input type="button" class="btn btn-danger pull-right" value="Sil" onclick="$('#image-row{{$image_row}}').remove();">
								</td>
							</tr>
						<?php $image_row++; ?>
        				@endforeach
        			</tbody>
        			<tfoot>
	        			<tr>
	        				<td colspan="4">
	        					<div class="row pull-right text-right">
	        						<button type="button" class="btn btn-warning" onclick="javascript:addImage()">Yeni Resim</button>
	        					</div>
	        				</td>
	        			</tr>
        			</tfoot>
	        	</table>
	        </div>
	      </div>
	    </div>
    </div>
	{{	Form::close()}}
</div>
@stop

@section('footerScripts')
	{{ HTML::script('assets/js/lib/ckeditor/ckeditor.js') }}
	{{ HTML::script('assets/js/bootstrap-datepicker.js') }}
	<script type="text/javascript">

		var image_row = <?php echo $image_row; ?>;

		function addImage() 
		{
			html   = '<tr id="image-row' + image_row + '">';
			html += '<td class="centered"><input type="hidden" name="medias[' + image_row + '][name]" value="" id="image' + image_row + '" /><input type="hidden" name="medias[' + image_row + '][path]" value="" id="image' + image_row +'_path" /><input type="hidden" name="medias[' + image_row + '][base_url]" value="" id="image' + image_row +'_base_url" /><img src="<?php echo Request::root().'/assets/thumbnail.php?src=&w=100&h=100&zc=1'?>" alt="" id="preview' + image_row + '" class="image" onclick="image_upload(\'image' + image_row + '\', \'preview' + image_row + '\');" /></td>';
			html += '<td class="centered"><input type="text" name="medias[' + image_row + '][sort_order]" class="col-md-2 local-form-control text-right" value="1" /></td>';			
			html += '<td class="centered"><input type="button" class="btn btn-danger pull-right" value="Sil" onclick="$(\'#image-row' + image_row  + '\').remove();"></td>';
			html += '</tr>';
			
			$('#images tbody').append(html);		
			image_row++;
		}

		function image_upload(field, preview) {
				$('#'+preview).live('click', function(e) {

					var fm = $('<div style="font-size:14px;" />').dialogelfinder({
							url : '{{URL::to('assets/elfinder/php/connector.php')}}',
							lang : 'tr',
							title: 'İmaj Yöneticisi',
							width : 860,
							destroyOnClose : true,
							getFileCallback : function(files, fm) {
								
								var path=files.split("../../");
								var realPath ='';
								if (path[1])
								{
									realPath=path[1];
								}
								
								var filesName = files.split('/');
								filesName = filesName[filesName.length-1];
								//console.log(filesName);
								$('#'+field).val(filesName);
								$('#'+preview).attr({src: '<?php echo Request::root()."/"?>assets/thumbnail.php?src=assets/'+realPath});
								$('#'+field+'_path').val(realPath);
								$('#'+field+'_base_url').val('<?php echo Request::root()."/"?>assets/'+realPath);						
								//console.log(files);
							},
							commandsOptions : {
								getfile : {
									oncomplete : 'close',
									folders : false
								}
							}
						}).dialogelfinder('instance')
				});	
			}	

	</script>
@stop

@section('footerJqueries')
	
	$('input#article_published_on').datepicker({
      format: 'yyyy-mm-dd',
      weekStart: 1,
	});
	$('input#article_published_off').datepicker({
      format: 'yyyy-mm-dd',
      weekStart: 1,
	});


	CKEDITOR.replace('articleSummary');
	CKEDITOR.replace('articleContent');
@stop
