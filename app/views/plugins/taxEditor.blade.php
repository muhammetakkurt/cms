<!-- New Tax Class Modal -->
<div id="TaxClassEditor" class="modal hide fade">
  <div class="modal-header">
    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
    <h3>Yeni Vergi Tanımla</h3>
  </div>
  <div class="modal-body">
  	{{	Form::open(array('url' => 'taxes' , 'method' => 'post', 'id' => 'newTaxClassForm', 'class' => 'form-horizontal'))	}}
      
      <div class="control-group">
        <label for="name" class="control-label">Vergi Adı</label>
        <div class="controls">
         	{{	Form::text('name','',array('placeholder' => 'Vergi adı (örn: K.D.V.)', 'required' => '' , 'id' => 'name')) }}
        </div>
      </div>

      <div class="control-group">
      		{{ Form::label('percent', 'Vergi Oranı', array('class' => 'control-label')) }}
      		<div class="controls">
      			<div class="input-prepend">
    					<span class="add-on">%</span>
    		      		{{ Form::text('percent', '', array('placeholder' => '18', 
    		      											   'required' => '', 
    		      											   'class' => 'span1',
    		      											   'pattern' => '(?:[0-9][0-9]?[0-9]?\.?[0-9]?[0-9]?)',
    		      											   'maxlength' => 6)) }}
				    </div>
      		</div>
      </div>
     {{ 	Form::close() }}
  </div>
  <div class="modal-footer"><a href="#" data-dismiss="modal" class="btn">İptal</a>
  	{{	Form::submit('Ekle', array('class' =>'btn btn-primary' , 'form' => 'newTaxClassForm' ))}}
  </div>
</div>
<!-- End of New Tax Class Modal -->