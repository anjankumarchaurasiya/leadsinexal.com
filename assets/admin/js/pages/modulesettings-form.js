

$(document).ready(function() {
$("#attributetype").on('change', function() {	
	"use strict";
    var type1 = $(this).val();
	  if(type1 == "radio(select one)" || type1 == "checkbox(multiple select)" || type1 == "select(dropdown)"){
	    $('.values').show();
	  }
	  else
	  {
	   $('.values').hide();
	  }
 }); 
$("#attributetype").trigger('change');
var type1 = $("#validateattr").val();
	if($("#attributevalue").val()){
		$('.values').show();
	}
	if($('#maximum').val() && jQuery.inArray('max_length', type1) !='-1'){
		$('.maximum').show();
	}
	if($('#minimum').val() && jQuery.inArray('min_length', type1) !='-1'){
		$('.minimum').show();
	}
 $("#validateattr").on('change',function(){
 	"use strict";
 	var typevalue = $(this).val();
 	if(jQuery.inArray('max_length', typevalue) =='-1' && jQuery.inArray('min_length', typevalue) =='-1'){
 		$('.maximum').hide();
 		$('.minimum').hide();
 	}else{
 	for( var i=0; i<typevalue.length; i++){
	 	if(typevalue[i] == "min_length"){
	 		$('.minimum').show();
	 		$('.maximum').hide();
	 	}if(typevalue[i] == "max_length"){
	 		$('.maximum').show();
	 		$('.minimum').hide();
	 	}if(jQuery.inArray('max_length', typevalue) !='-1' && jQuery.inArray('min_length', typevalue) !='-1'){
	 		$('.maximum').show();
	 		$('.minimum').show();
	 	}
 	}
 }
 });
 $("#validateattr").trigger('change');

});