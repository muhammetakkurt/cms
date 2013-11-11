$("button[type='submit'] , input[type='submit']").click(function(){
			
	var self = this;

	$("#required-status-message-div").empty();
	
	requiredError = '';
	$("input[required] , textarea[required]").each(function(i){
        if($(this).attr("required")){
            
            if(self.form == this.form)
    		{
				if (this.value=='')
    			{
    				if(this.title!='')
    				{
    					requiredError+=this.title+', ';
    				}
    				else
    				{
    					requiredError+=this.placeholder+', ';	
    				}
    				
    			}
    		}
    	}
	});
	
	if (requiredError.length>0)
	{
		requiredError = requiredError.substring(0,requiredError.length-2);
		
		var n=requiredError.split(",");
		if(n.length>1)
		{
			requiredError+=' alanlarını doldurmanız gerekmektedir.';
		}else{
			requiredError+=' alanını doldurmanız gerekmektedir.';
		}

        $("#required-status-message-div").append(requiredError);
        
        $("#required-control").fadeIn();
        /*
        if(typeof $(self).parents('.modal').html() == 'undefined')
        {	
        	$("#required-control").fadeIn();

        	setTimeout(function()
	        {
	  			$('#required-control').fadeOut( 700 );
	        },3000);
    	}
    	else
    	{
    		$(self).parents('.modal').find('.modal-header').append($("#required-status-message-div").html());
    	}
    	*/
    }
	else
	{
		if($("#required-control").css('display')=="block")
		{
			$("#required-control").fadeOut();
			self.form.submit();
		}

	}
});