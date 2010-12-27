$(function(){
		var max= 0;
 		$("label").each(function(){
			if($(this).width() > max){
					max = $(this).width();	
				}
			});
		
	
		$("label").css('width', max);   
		   
		$("#contact_form").validate({
			errorPlacement: function(error, element) {
       			error.insertBefore(element);
			},submitHandler: function(form) {
   				$(form).ajaxSubmit({
				target: '#output',
				beforeSubmit: function(){
					$("#contact_form input[type=submit]").hide(100,function(){
								$("#contact_form textarea").after("<span><em>Sending...</em></span>");
					});
				},
				success: function(){
						$("#contact_form").fadeOut(400,function(){
							$("#output").fadeIn(400);
							 });
						}
				});
  			 }
   			
		});	   

});

/**/