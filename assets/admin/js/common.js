/**
 * Elektron - An Admin Toolkit
 * @version 0.3.1
 * @license MIT
 * @link https://github.com/onokumus/elektron#readme
 */



// Resizing Graphs
$(window).trigger('resize'); 

var width = $(window).width();
$(window).on('resize', function(){
	'use strict';
	if($(this).width() != width){
		width = $(this).width();
		if(width<1100){
			$('#app-side').onoffcanvas('hide');
		}
	}
});

// eslint-disable no-undef
$(function () {
	'use strict';
	if ($(window).width() < 992) {
		$('#app-side').onoffcanvas('hide');
	} else {
		$('#app-side').onoffcanvas('show');
	}

	$('.side-nav .unifyMenu').unifyMenu({ toggle: true });

	$('#app-side-hoverable-toggler').on('click', function () {
		$('.app-side').toggleClass('is-hoverable');
		$(undefined).children('i.fa').toggleClass('fa-angle-right fa-angle-left');
	});


	$('#onoffcanvas-nav').on('click', function () {
		'use strict';
		$('.app-side').toggleClass('left-toggle');
		$('.app-main').toggleClass('left-toggle');
		$("#onoffcanvas-nav i").toggleClass('open mini');
	});
	
	$('.onoffcanvas-toggler').on('click', function () {
		'use strict';
		$(".onoffcanvas-toggler i").toggleClass('open mini');
	});
});




// Bootstrap Tooltip
$(function () {
	$('[data-toggle="tooltip"]').tooltip();
})



// Bootstrap Popover
$(function () {
  $('[data-toggle="popover"]').popover()
})
$('.popover-dismiss').popover({
  trigger: 'focus'
})



// Task list
$('.task-list').on('click', 'li.list', function() {
	$(this).toggleClass('completed');
});



// Todo list
$('.todo-body').on('click', 'li.todo-list', function() {
	$(this).toggleClass('done');
});



// Loading
$(function() {
	$("#loading-wrapper").fadeOut(2000);
});

$(document).ready(function() {
	setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 10000); // <-- time in milliseconds
});



// Setting Main Content Dynamic Height
$(window).on("load resize",function(e){
  $('.main-content').css('min-height', (window.innerHeight) - 170);
});



// Textarea characters left
$(function() {
	$('#characterLeft').text('140 characters left');
	$('#message').keydown(function () {
		var max = 140;
		var len = $(this).val().length;
		if (len >= max) {
			$('#characterLeft').text('You have reached the limit');
			$('#characterLeft').addClass('red');
			$('#btnSubmit').addClass('disabled');            
		} 
		else {
			var ch = max - len;
			$('#characterLeft').text(ch + ' characters left');
			$('#btnSubmit').removeClass('disabled');
			$('#characterLeft').removeClass('red');            
		}
	});
});


// Todays Date
$(function() {
	var interval = setInterval(function() {
		var momentNow = moment();
		$('#today-date').html(momentNow.format('MMMM . DD') + ' '
		+ momentNow.format('. dddd').substring(0, 12));
	}, 100);
});


// Tasks
(function($) {
  var checkList = $('.check'),
	toDoCheck = checkList.children('input[type="checkbox"]');
  toDoCheck.each(function(index, element) {
    var $this = $(element),
		taskItem = $this.closest('li');
    $this.on('click', function(e) {
			taskItem.toggleClass('task-checked');
    });
  });
})(jQuery);


// Adding and Removing Shadow to Header on Scroll
$(window).scroll(function() {     
	var scroll = $(window).scrollTop();
	if (scroll > 10) {
		$(".app-header").addClass("btm-shadow");
	}
	else {
		$(".app-header").removeClass("btm-shadow");
	}
});
$('body').bind('copy paste',function(e) {
    e.preventDefault(); return false; 
});

// Setting Chat Container Max Height
$(window).on("load resize",function(e){
  $('.chat-box').css('max-height', (window.innerHeight) - 370);
});

$(window).on("load resize",function(e){
  $('.users-container .users').css('max-height', (window.innerHeight) - 300);
});