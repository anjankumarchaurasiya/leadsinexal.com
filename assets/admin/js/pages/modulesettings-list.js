

$(document).ready(function(){
		var cms = [];
		$('#datatable').DataTable({
			columnDefs: [
			    { orderable: false, targets: [0,-1] }
			],
			aaSorting: [[1, 'asc']]

		});

		 $('#checkalluser').prop('checked', false); 
			        for(var i=0; i<=cms.length; i++){
			            $("input[value="+cms[i]+"]").attr('checked', true); 
			                    
			        }
        
		        $("#checkalluser").on('click',function () {
		        	"use strict";
		                if($(this).is(":checked")){
		                    $('.values').prop('checked', $(this).prop('checked'));
		                    $('.values:checked').each(function(i){
		                        if($.inArray($(this).val(), cms) !== -1){
		                            cms = jQuery.grep(user, function(value) {
		                            return value != ($(this).val());
		                            });
		                        }else{
		                                cms.push($(this).val());
		                            }
		                    });
		                }else{
		                    cms = [];
		                    $('.values').prop('checked', $(this).prop('checked'));
		                }
		        });
	            $(".values").on('click',function () {
	            	"use strict";
	                var values = $(this).val();
	                if($(this).is(":checked"))
	                    { 
	                        cms.push(values);
	                    }else{
	                        if($.inArray(values, cms) !== -1){
	                        cms = jQuery.grep(cms, function(value) {
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
	                	"use strict";
	                cms[i] = $(this).val();
	                 });
	                if(cms.length == "0"){
	                    window.location.reload();
	                }else{
	                	var destroy = $("#destroy").val();
	                 $.ajax({
	                    "url": destroy,
	                    dataType: 'html',
		                type: 'post',
		                data: {"data" : cms},
		                success: function( data ){

		                	window.location.reload();
		                },
	                   });
 
	            }
			}
		});
	});