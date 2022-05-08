
$(document).ready(function(){

		$('.banip').on('click',function(){
			"use strict";

	  	var id = $(this).attr('id');
	  	var ip = $(this).find("a").attr('data-pk');
		$.fn.editable.defaults.mode = 'inline';
		var updateurl = $('#updateurl').val();
		  $(this).editable({
			    type: 'text',
			    pk: ip,
			    url: updateurl+ip ,
			    title: 'IP',
				success: function(response, newValue) {
		      
		   		 }
			});
		  setTimeout(function(){
		  	"use strict";
		  $('.glyphicon-ok').attr('class','icon-tick');
		  $('.glyphicon-remove').attr('class','icon-times');
		},10);
		})

		var banip = [];
		$('#datatable').DataTable({
			columnDefs: [
			    { orderable: false, targets: [0,-1] }
			],
			aaSorting: [[1, 'asc']]

		});

		 $('#checkalluser').prop('checked', false); 
			        for(var i=0; i<=banip.length; i++){
			            $("input[value="+banip[i]+"]").attr('checked', true); 
			                    
			        }
        
		        $("#checkalluser").on('click',function () {
		        	"use strict";
		        	var user;
		                if($(this).is(":checked")){
		                    $('.values').prop('checked', $(this).prop('checked'));
		                    $('.values:checked').each(function(i){
		                        if($.inArray($(this).val(), banip) !== -1){
		                            banip = jQuery.grep(user, function(value) {
		                            return value != ($(this).val());
		                            });
		                        }else{
		                                banip.push($(this).val());
		                            }
		                    });
		                }else{
		                    banip = [];
		                    $('.values').prop('checked', $(this).prop('checked'));
		                }
		        });
	            $(".values").on('click',function () {
	            	"use strict";
	                var values = $(this).val();
	                if($(this).is(":checked"))
	                    { 
	                        banip.push(values);
	                    }else{
	                        if($.inArray(values, banip) !== -1){
	                        banip = jQuery.grep(banip, function(value) {
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
	                banip[i] = $(this).val();
	                 });
	                if(banip.length == "0"){
	                    window.location.reload();
	                }else{
	                	var destroy = $('#destroy').val();
	                 $.ajax({
	                    "url": destroy,
	                    dataType: 'html',
		                type: 'post',
		                data: {"data" : banip},
		                success: function( data ){

		                	window.location.reload();
		                },
	                   });
 
	            }
			}
		});

		
		$('td').dblclick(function(){
			"use strict";
		  var id = $(this).attr('id');
		  var action = '<input type="text" name="IP" class="form-control"/>';

		})
	});