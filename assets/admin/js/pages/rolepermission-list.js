

$(document).ready(function(){
	"use strict";
		$('#datatable').DataTable({
			columnDefs: [
			   { orderable: false, targets: -1 }
			]
		});
		// function removemaskeddata(roleid,userid,exal_id,name) {
		// 	$('.exaldata').html(name);
		// 	$('#myModal').modal('show');
		// }
		// function functionshow() {
		// 	// $('.exaldata').html(name);
		// 	$('#myModal').modal('show');
		// }
	    function alignModal(){
	        var modalDialog = $(this).find(".modal-dialog");
	        
	        // Applying the top margin on modal to align it vertically center
	        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
	    }
	    // Align modal when it is displayed
	    $(".modal").on("shown.bs.modal", alignModal);
	    
	    // Align modal when user resize the window
	    $(window).on("resize", function(){
	        $(".modal:visible").each(alignModal);
	    });   
 
	});