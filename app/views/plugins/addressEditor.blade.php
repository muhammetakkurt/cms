<!-- Address Modal -->
<div id="address-editor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <span id="editor_header">Adres Düzenle</span> (<span id="address_caption_header"></span>)
                </h4>
            </div>
            <div class="modal-body address-modal">
                
                <form>
                    <legend>Genel Bilgiler</legend>
                    <div class="line-container">
                        <div class="description">Adres Başlığı</div>
                        <div class="input">
                            {{ Form::hidden('address_id', '', array('id' => 'address_id'))}}
                            {{ Form::text('address_caption', '', array('id' => 'address_caption', 
                                                                       'required', 
                                                                       'class' => 'form-control', 
                                                                       'placeholder' => 'Adres Başlığı'))
                            }}
                        </div>
                    </div>
                    <div class="input">
                        {{ Form::checkbox('default_address', 1, 0, array('id' => 'default_address'))}}
                        <label class="checkbox" for="default_address">Varsayılan adres olarak işaretle</label>    
                    </div>
                    <legend>Alıcı Bilgileri</legend>
                    <div class="partial-line-container-l">
                        <div class="description">Adı</div>
                        {{ Form::text('address_hoster_name', '', array('id' => 'address_hoster_name' , 
                                                                       'required', 
                                                                       'class' => 'form-control', 
                                                                       'placeholder' => 'Alıcının Adı')) 
                        }}
                    </div>
                    <div class="partial-line-container-r">
                        <div class="description">
                            Soyadı
                        </div>
                        {{ Form::text('address_hoster_surname', '', array('id' => 'address_hoster_surname' , 
                                                                          'required', 
                                                                          'class' => 'form-control', 
                                                                          'placeholder' => 'Alıcının Soyadı' )) 
                        }}
                    </div>
                    <div class="partial-line-container-l">
                        <div class="description">
                            Tel:
                        </div>
                        {{ Form::text('address_hoster_telephone_number', '', array('id' => 'address_hoster_telephone_number', 
                                                                                   'maxlength' => '10' , 
                                                                                   'pattern' => '[0-9]{10}' , 
                                                                                   'required', 
                                                                                   'class' => 'form-control', 
                                                                                   'placeholder' => 'Alıcının Telefon Numarası')) 
                        }}
                    </div>
                    <legend>Adres Bilgileri</legend>
                    <div class="line-container">
                        <div class="description">Açık Adres</div>
                        <div class="input">
                            {{ Form::textarea('address_detail', '', array('id' => 'address_detail', 
                                                                          'rows' => '2', 
                                                                          'class' => 'form-control', 
                                                                          'required', 
                                                                          'placeholder' => 'Açık Adres')) 
                            }}
                        </div>
                    </div>
                    <div class="line-container">
                        <div class="description">
                            İl
                        </div>
                            {{ Form::select('address_city_id', $cities, Sentry::getUser()->city_id, 
                                            array('id' => 'address_city_id', 
                                                'onChange' => 'getTowns(this.value, "address_town_id");', 
                                                'class' => 'form-control'
                                            )
                                    ) 
                            }}
                    </div>
                    <div class="line-container">
                        <div class="description">
                            İlçe
                        </div>
                        {{ Form::select('address_town_id', array(), '', array('id' => 'address_town_id', 
                                                                          'class' => 'form-control')) 
                        }}
                    </div>
                    <div class="line-container">
                        <div class="description">
                            P.K.:
                        </div>
                        {{ Form::text('address_postcode', '', array('id' => 'address_postcode' , 
                                                                    'maxlength' => '5' , 
                                                                    'pattern' => '[0-9]{5}' , 
                                                                    'required', 
                                                                    'class' => 'form-control', 
                                                                    'placeholder' => 'Posta Kodu')) 
                        }}
                    </div>
                </form>
                      
            </div>
            <div class="modal-footer">
                <p id="address-editor-result"></p>
                <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-primary" onClick="save_address()">Kaydet</button>
            </div>
        </div>
    </div>
</div>
<!-- End of address modal -->