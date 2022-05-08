
$(document).ready(function(){
	"use strict";
		$('.datepicker').datetimepicker({
			format: 'Y-m-d',
			timepicker: false,
			closeOnDateSelect: true,
			scrollInput: false,
			maxDate: 'now()',
		});
		  $('.summernote').summernote({
	        height: 180,
	        tabsize: 2
	      });
});