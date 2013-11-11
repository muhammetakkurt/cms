// required (zorunlu) olan inputları döngüye sokup ingilizce metinleri input bilgilerine göre değiştiriyoruz.
function requiredControl()
{
	var intputElements = document.getElementsByTagName("INPUT");
    $("input").each(function(i){
        if($(this).attr("required")){
            intputElements[i].oninvalid = function (e) {
	            e.target.setCustomValidity("");
	            if (!e.target.validity.valid) {
					e.target.setCustomValidity("'"+(e.target.placeholder == '' ? e.target.title : e.target.placeholder)+"' alanı gereklidir.");
	            }
	        };
        }
	});
	
    var intputElements = document.getElementsByTagName("TEXTAREA");
    $("textarea").each(function(i){
        if($(this).attr("required")){
            intputElements[i].oninvalid = function (e) {
	            e.target.setCustomValidity("");
	            if (!e.target.validity.valid) {
					e.target.setCustomValidity("'"+(e.target.placeholder == '' ? e.target.title : e.target.placeholder)+"' alanı gereklidir.");
	            }
	        };
        }
	});	
}

requiredControl();
	   	
	   	