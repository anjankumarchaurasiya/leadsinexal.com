

	$(document).ready(function(){
		var user = [];
		$('#datatable').DataTable({
			columnDefs: [
			   { orderable: false, targets: [0,-1] }
			],
			aaSorting: [[1, 'asc']]
		});

		 $('#checkalluser').prop('checked', false); 
			        for(var i=0; i<=user.length; i++){
			            $("input[value="+user[i]+"]").attr('checked', true); 
			              
			        }
        
		        $("#checkalluser").on('click',function () {
		        	"use strict";
		                if($(this).is(":checked")){
		                    $('.values').prop('checked', $(this).prop('checked'));
		                    $('.values:checked').each(function(i){
		                        if($.inArray($(this).val(), user) !== -1){
		                            user = jQuery.grep(user, function(value) {
		                            return value != ($(this).val());
		                            });
		                        }else{
		                                user.push($(this).val());
		                            }
		                    });
		                }else{
		                    user = [];
		                    $('.values').prop('checked', $(this).prop('checked'));
		                }
		        });

	            $(".values").on('click',function () {
	            	"use strict";
	                var values = $(this).val();
	                if($(this).is(":checked"))
	                    { 
	                        user.push(values);
	                    }else{
	                        if($.inArray(values, user) !== -1){
	                        user = jQuery.grep(user, function(value) {
	                        return value != values;
	                        });
	                    }

	                    }
	            });

		$("#deletevalue").on('click',function () {
			"use strict";
			var  r = confirm('Are you sure?');
			if(r === true){
		
	                
	                $('.values:checked').each(function(i){
	                user[i] = $(this).val();
	                 });
	                if(user.length == "0"){
	                	var userurl = $('#userurl').val();
	                 var url = userurl+user;
	                }else{
	                	var destroy = $('#destroy').val();
	                 $.ajax({
	                    "url": destroy,
	                    dataType: 'html',
		                type: 'post',
		                data: {"data" : user},
		                success: function( data ){
		                	window.location.reload();
		                },
	                   });
	            }
			}
		});
	});