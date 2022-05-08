
$(document).ready(function(){
	$('.datepicker').datetimepicker({
		format: 'Y-m-d',
		timepicker: false,
		closeOnDateSelect: true,
		scrollInput: false,
		maxDate: 'now()',
	});
	
	/***
	 * Set min date in html5
	 */ 
	var today = new Date().toISOString().slice(0, 16);
	var element =  document.getElementsByName("link_expire_duration");
	if (element.length)
	{
	   document.getElementsByName("link_expire_duration")[0].min = today;	
	}
	$('.summernote').summernote({
	        height: 180,
	        tabsize: 2
	      });


	$(this).closest('tr').find('.chkcol:checked');
		$(this).find('.view').each(function () {
           if (this.checked) {
               $(this).closest('tr').find('.chkcol').removeAttr("disabled");
           }else{
           	$(this).closest('tr').find('.chkcol').attr("disabled", true).attr("checked", false);
           	$(this).removeAttr("disabled");
           }
		});

		$('.view').click(function(){
			if (this.checked) {
			 $(this).closest('tr').find('.chkcol').removeAttr("disabled");

			}else{
			 $(this).closest('tr').find('.chkcol').attr("disabled", true).attr("checked", false);
			 $(this).closest('tr').find('.chkcol').prop("checked", false);
			 $(".view").removeAttr("disabled");
			}
		});

		$('.chkrow').click(function(){
			$(this).closest('tr').find('input:checkbox').not(this).prop('checked', this.checked);
			if(this.checked){
			$(this).closest('tr').find('.chkcol').removeAttr("disabled");
			}else{
				$(this).closest('tr').find('.chkcol').attr("disabled", true).attr("checked", false);
				$(".view").removeAttr("disabled");
			}

		});
		$('.chkcol').click(function(){
			if ($(this).closest('tr').find('.chkcol:checked').length == $(this).closest('tr').find('.chkcol').length) {
					$(this).closest('tr').find('.chkrow').prop('checked', true);
					$(this).closest('tr').find('.chkcol').removeAttr("disabled");
			}
			else{
			}
		});
	if($('.city').is(':disabled'))
	{
		$('.city').append('<option selected value="">Select state first</option>');	
	}
	if($('.location').is(':disabled'))
	{
		$('.location').append('<option selected value="">Select district first</option>');	
	}
 	// $('.city').select2("enable", false);
	$('.state').on('change',function(){
		$('.location').append('<option selected value="">Select district first</option>');
		$('.location').select2("enable", false);
		var exal_id = $('.exal_id').val();
		$.ajax({
	        "url":baseurl+"/admin/exal/citylist",
	        "type":'post',
	        "data":{exal_id:exal_id,state:this.value},
	        'dataType':'json',
	        beforesend:function()
	        {
			  $('.city').prop('disabled', true);
	        },
	        success: function(data){
	      		if(data.status == true)
	      		{ 
	      			$('.city').prop('disabled', false);
	      			var lsit = '<option value="">Select district</option>';
	      			data.data.forEach(function (data) {
	      				const district_selected = (filter_district == data.district)?'selected':'';
	      				lsit += '<option value="' + data.district + '" '+district_selected+'>' + data.district + '</option>';   
	      				if(district_selected == "selected")
	      				{	
	      					const exal_id = $('.exal_id').val();
	      					const district = data.district;
	      					cityselected(exal_id,district);
	      				}
			        });
			        $('.city').html(lsit);
	      		}else{
	      			$('.city').append('<option value="" selected>District is not available</option>')	
	      			$('.city').prop('disabled', true);
	      		}
	        },
	 	});
	});
 	// $('.location').select2("enable", false);
 	$('.city').on('change',function(){
		var exal_id = $('.exal_id').val();
		var district = this.value; 
		cityselected(exal_id,district);
	});
	if($('.city').val())
	{
		$( ".city" ).change();
	}
	if($('.state').val())
	{
		$( ".state" ).change();
	}
	function cityselected(exal_id,district)
	{
		$.ajax({
	        "url":baseurl+"/admin/exal/locationlist",
	        "type":'post',
	        "data":{exal_id:exal_id,district:district},
	        'dataType':'json',
	        beforesend:function()
	        {
			  $('.location').prop('disabled', true);
	        },
	        success: function(data){
	      		if(data.status == true)
	      		{ 
	      			$('.location').prop('disabled', false);
	      			var lsit = '<option value="">Select location</option>';
	      			data.data.forEach(function (data) {
	      				const location_selected = (filter_location == data.location)?'selected':'';

	      				lsit += '<option  value="' + data.location + '" '+location_selected+'>' + data.location + '</option>';   
			        });
			        $('.location').html(lsit);
	      		}else{
	      			$('.location').append('<option value="" selected>Location is not available</option>')	
	      			$('.location').prop('disabled', true);
	      		}
	        },
	 	});
	}
	$('.assigned-action').on('click',function(e){
		var assignid = $(this).data('assignid');
		var button = $(this);
		$.ajax({
	        "url":baseurl+"/admin/exal/changestatus",
	        "type":'post',
	        "data":{assignid:assignid},
	        'dataType':'json',
	        'async' : true,
	        beforesend:function()
	        {
			   $(this).prop('disabled', true);
	        },
	        success: function(data){
	      		$(this).prop('disabled', false);
	      		
	      		if(data.status == true)
	      		{

	      			if(data.data == 1)
	      			{
	      				button.html(' Yes ');
	      				button.removeClass('btn-danger').addClass('btn-success');  
	      				button.removeClass('fa-ban').addClass('fa-check');  
	      				Message.add(data.message, {vertical:'top',horizontal:'center',type: 'success'});
	      			}else{
	      				button.html(' No ');
	      				button.removeClass('btn-success').addClass('btn-danger');  
	      				button.removeClass('fa-check').addClass('fa-ban');  
	      				Message.add(data.message, {vertical:'top',horizontal:'center',type: 'error'});
	      			}
	      			 
	      		} 
	        },
	 	}); 
	});
	
	function randomPassword(length) {
	    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
	    var pass = "";
	    for (var x = 0; x < length; x++) {
	        var i = Math.floor(Math.random() * chars.length);
	        pass += chars.charAt(i);
	    }
	    return pass;
	}
 	$('.password-generate').on('click',function(e){
 		if($('.password-generate').is(":checked"))
 		{
 			var password_generated = randomPassword(10);
 			 
 			$('#password').val(password_generated);
 		}else{
 
 			$('#password').val('');
 		}
 		
 	});
	 
});