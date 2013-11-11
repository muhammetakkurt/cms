<script type="text/javascript">
	function getTowns(city_id, town_id, town_to_select)
	{
		if (town_id == null)
		{
			town_id = 'towns';
		}
		if (town_to_select == null)
		{
			town_to_select = 0;
		}
		$('#'+town_id).empty();
		$.get("{{URL::to('ajax/towns')}}/"+city_id, function(data) {
		  var data = $.parseJSON(data);
		  $.each(data, function (i,item) {
		  		$('#'+town_id).append($('<option>', { 

			        value: item.id,
			        text: item.name
			        
			    }));
			});
		  	if(town_to_select != null)
				$('#address_town_id option[value="'+town_to_select+'"]').prop('selected', true);
		});
		
		
	}
</script>