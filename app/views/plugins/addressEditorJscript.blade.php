	<script type="text/javascript">
	var address_holders = {0: 'user_payment_address_id', 1: 'user_shipping_address_id', 2: 'address-list'};
	var address_containers = {0: 'payment_address_container', 1: 'shipping_address_container'};
	var addresses = {};
	function open_new_address_editor()
	{
		$( '#editor_header' ).html('Yeni Adres Ekle');
		open_address_editor();
		$( '#address_caption' ).focus();
	}
	function open_address_editor(address_id)
	{
		clear_address_form();
		//console.log(addresses);
		$.each(addresses, function(i, address){
			if(address.id == address_id){
				getTowns(address.city.id, "address_town_id", address.town.id);
				$( '#address_caption_header' ).html(address.caption);
				//console.log(address);
				$( '#address_id' ).val(address.id);
				$( '#address_caption' ).val(address.caption);
				$( '#address_hoster_name' ).val(address.name);
				$( '#address_hoster_surname' ).val(address.surname);
				$( '#address_hoster_telephone_number' ).val(address.phone_number);
				$( '#address_detail' ).val(address.detail);
				$( '#address_city_id' ).val(address.city.id);
				$( '#address_town_id' ).val(address.town.id);
				$( '#address_postcode' ).val(address.postcode);
				if(address.is_default == 1)
				{
					$('#default_address').prop('checked', true);
				}
				else
				{
					$('#default_address').prop('checked', false);
				}
			}
		});
		$( '#address_caption' ).focus();
	}
	function reload_address_information()
	{
		$.each(address_holders, function(h, holder){
			$( '#'+holder ).empty();
		});	
		$.getJSON("{{URL::to('ajax/active-user-details')}}", function( data ){
			if(data.hasOwnProperty('addresses'))
			{
				$( '.address-edit-button' ).show();
				$.each(address_containers, function(c, container){
					$('#' + container + ">select:first").show();
					$('#' + container + ">div:first").hide();
				});
				addresses = data.addresses;
				$.each(data.addresses, function(i, address){
					append_address(address);
				});
			}
			else
			{
				$( '.address-edit-button' ).hide();
				$.each(address_containers, function(c, container){
					$( '#' + container + ">select:first").hide();
					$( '#' + container).parents("div:eq(0)>button:nth-child(2)").toggle();
					$( '#' + container ).append(
						'<div class="well">' +
							'<i class="icon-info-sign"></i>' +
							'<span> Henüz sistemimizde kayıtlı bir adresiniz bulunmuyor.</span>' +
						'</div>'
					);
				});
			}
		});	
	}
	function remove_address(id)
	{
		$.post("{{ URL::to('account/remove-address') }}", {
			address_id: id
		}).done(function( data ){
			data = $.parseJSON(data);
			if(data.result == 'success')
			{
				reload_address_information();
			}
			else if (data.result == 'error')
			{
				alert('İşleminiz gerçekleştirilemedi.');
			}
		});
	}
	function save_address()
	{
		$( '#address-editor-result' ).html('');
		$.post("{{ URL::to('account/address-json') }}", {
			address_id: $( '#address_id' ).val(),
			address_caption: $( '#address_caption' ).val(),
			address_hoster_name: $( '#address_hoster_name' ).val(),
			address_hoster_surname: $( '#address_hoster_surname' ).val(),
			address_hoster_telephone_number: $( '#address_hoster_telephone_number' ).val(),
			address_detail: $( '#address_detail' ).val(),
			city_id: $( '#address_city_id' ).val(),
			town_id: $( '#address_town_id' ).val(),
			address_postcode: $( '#address_postcode' ).val(),
			default_address: $( '#default_address' ).is(':checked') ? 1 : 0,
		}).done(function( data ){
			data = $.parseJSON(data);
			if(data.result == 'success')
			{
				$( '#address-editor' ).modal('hide');
				reload_address_information();
			}
			else if(data.result == 'validation_error')
			{
				//console.log(data.error_messages[Object.keys(data.error_messages)[0]][0]);
				$( '#address-editor-result' ).text( data.error_messages[Object.keys(data.error_messages)[0]][0] );
			}
			else
			{
				$( '#address-editor-result' ).text('İşlem gerçekleştirilemedi.');
			}
		});
	}
	function clear_address_form()
	{
		$( '#address_caption_header' ).html('');
		$( '#address_id' ).val('');
		$( '#address_caption' ).val('');
		$( '#default_address' ).prop('checked', false);
		$( '#address_hoster_name' ).val('');
		$( '#address_hoster_surname' ).val('');
		$( '#address_hoster_telephone_number' ).val('');
		$( '#address_detail' ).val('');
		$( '#address_city_id' ).val(0);
		$( '#address_town_id' ).html('');
		$( '#address_postcode' ).val('');
		$( '#address-editor-result' ).text('');
	}
	function decide_order_type() //according to radio boxes
	{
		var arbiter = $('input:radio[name="order_type"]:checked');
		if(arbiter.val() == 'personal')
		{
			$('#personal_information').show();
			$('#corporate_information').hide();
		}
		else if(arbiter.val() == 'corporate')
		{
			$('#personal_information').hide();
			$('#corporate_information').show();
		}
	}
	$(function() {
		$( '#address_caption' ).keyup(function() {
			$('#address_caption_header').html($(this).val());	
		});
	});
	</script>