

$(document).ready(function() {
	$(".validation").hide();
	$("#SignUp").on('submit',function(e) {
		"use strict";
        //prevent Default functionality
        e.preventDefault();

        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        //do your own request an handle the results
        var userurl = $("#userurl").val();
        console.log(userurl);																																																																																																																																												
        $.ajax({
                url: actionurl,
                type: 'post',
                data: $("#SignUp").serialize(),
                success: function(data) {
                var d = JSON.parse(data);
                if(d.status === false){
					$(".validation").show();
					var html = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" id="cross">×</span></button><i class="icon-warning2"></i><strong>Oh snap!</strong><ul></ul></div>';
					$(".validation").html(html);
					$(".validation").find("ul").html(d.validation);
				}else{
					var userurl = $("#userurl").val();
					window.location = userurl;
				}
                }
        });

    	
    });

	$("#cross").on('click',function(){
		"use strict";
		$(".validation").hide();
	})
	
	var email = $("#email").val();
	if(email){
		var editattribute = $("#editattribute").val();
		var urlsegment = $("#urlsegment").val();
		var id = urlsegment;
		var url = editattribute+id;
		console.log(url);
		$.ajax({
	        "url": url,
	        success: function(data){
	        	console.log(data);
	        	if(data != "false"){
	                $("#formmodel").html(data);
	            }
	        },
	 	});
	}else{
		var getattribute = $("#getattribute").val();
		var pageurl = $("#pageurl").val();
		var page = pageurl;
		url = getattribute;
	}
	$("#onchangerole").change(function() {
		var roleid = $(this).val();
		// if(roleid==3)
		// {
			
		// }
		$.ajax({
	        "url": url+'/'+roleid,
	        success: function(data){
	        	if(data != "false"){
	                $("#formmodel").html(data);
	            }
	        },
	 	});
	});
				  
});