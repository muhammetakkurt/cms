@extends('layouts.admin')
@section('title')
	{{$page->name.' Düzenleme'}} 
@stop
@include('plugins.elfinder')
@section('headerStyles')
	{{ HTML::style('assets/css/datepicker.css') }}
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<style type="text/css">
	form img{
		cursor: pointer;
	}
	</style>
@stop
@section('content')
<div class="row">
	
		{{	Form::open(array('url' => 'cms-pages/'.$page->id , 'method' => 'PUT', 'id' => 'editCmsPageForm'))	}}	


		<div class="col-md-12">
			<div class="col-md-3 pull-right text-right">
				<button type="submit" class="btn btn-warning"><i class="icon-ok"></i>&nbsp; Kaydet</button>
			</div>	
			<h4>{{$page->name.' Düzenleme'}}</h4>
		</div>
		<div class="col-md-12">
			<ul id="myTab" class="nav nav-tabs">
			  <li class="active"><a href="#general" data-toggle="tab">Genel</a></li>
			  <li class=""><a href="#images" data-toggle="tab">Resimler</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane fade in active" id="general">
			  	<div class="control-group">
	         			<div class="row">
	         				<div class="col-md-3" style="margin-left: 0px;">
         						<label for="published_on" class="control-label">Yayınlanma Tarihi </label>
	         					<div class="input-append">
								  {{	Form::text('published_on',$page->published_on,array('placeholder' => 'Yayınlanma Tarihi', 'id' => 'page_published_on' , 'class' => 'col-md-2 form-control')) }}
								  <span class="add-on"><i class="icon-list-alt"></i></span>
								</div>
							</div>
							<div class="col-md-4">
								<label for="published_off" class="control-label">Yayından Çekme Tarihi </label>
								<div class="input-append">
								  {{	Form::text('published_off',$page->published_off,array('placeholder' => 'Yayından Çekme Tarihi', 'id' => 'page_published_off' , 'class' => 'col-md-2 form-control')) }}
								  <span class="add-on"><i class="icon-list-alt"></i></span>
								</div>
							</div>
         				</div>
				    </div>
			    <div class="row">
			        <label for="parent_id" class="control-label col-md-12">Ana Kaynak </label>
			        <div class="col-md-6">
			        	{{ Form::select('parent_id', $pages, $page->parent_id , array('class' => 'form-control'))}}
			        </div>
			      </div>

			      <div class="row">
			        <label for="name" class="control-label col-md-12">Sayfa Adı </label>
			        <div class="col-md-6">
			         	{{	Form::text('name',$page->name,array('placeholder' => 'Sayfa Adı', 'required' => '' , 'class' => 'form-control'))}}
			        </div>
			      </div>
			      <div class="row">
			        <label for="name" class="control-label col-md-12">Sıralama </label>
			        <div class="col-md-6">
			         	{{	Form::text('sort_order',$page->sort_order,array('class' => 'col-md-1 form-control'))}}
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
        				@foreach($page->medias as $media)
        					<tr id="image-row{{$image_row}}">
								<td class="centered">
									<input type="hidden" name="medias[{{$image_row}}][id]" value="{{$media->id}}" id="image{{$image_row}}_id" />
									<input type="hidden" name="medias[{{$image_row}}][name]" value="{{$media->name}}" id="image{{$image_row}}" />
									<input type="hidden" name="medias[{{$image_row}}][path]" value="{{$media->path}}" id="image{{$image_row}}_path" />
									<input type="hidden" name="medias[{{$image_row}}][base_url]" value="" id="image{{$image_row}}_base_url" />
									<img src="<?php echo Request::root().'/assets/thumbnail.php?src='.$media->path?>" alt="" id="preview{{$image_row}}" class="image" onclick="image_upload('image{{$image_row}}','preview{{$image_row}}');" />
								</td>
								<td class="centered">
									<input type="text" name="medias[{{$image_row}}][sort_order]" class="col-md-1 text-right" value="{{$media->pivot->sort_order}}" />
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

		  
	    {{	Form::close()}}
	</div>
</div>
@stop

@section('footerScripts')
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
	
	$('input#page_published_on').datepicker({
      format: 'yyyy-mm-dd',
      weekStart: 1,
	});
	$('input#page_published_off').datepicker({
      format: 'yyyy-mm-dd',
      weekStart: 1,
	});
@stop