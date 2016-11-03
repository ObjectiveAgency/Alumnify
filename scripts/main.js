



// Logo fade in


$(function() {
$(document).ready( function () {
$('#logo-pop')
   .transition('fly down in')
;
	});
		});





// Header slide in effect:


$(function() {
$(document).ready( function () {
$('#headerin')
  .transition('fly right in')
;
	});
		});

// Menu Button pop:

$(function() {
$(document).ready( function () {
$('#show-me-pop')
  .transition('scale in')
;
	});
		});

// Header Scroll Arrow Flip:

$(function() {
$(document).ready( function () {
$('#arrow-flip')
  .transition('horizontal flip in')
;
	});
		});
	
	
	
// Sidebar Open:

$(function() {
			$('#toggler').click(function() {
				$('.ui.sidebar')
					.sidebar('toggle');
			});
		});
	

$(function() {
			$('a#modalcontact').click(function() {
$('.ui.basic.modal')
  .modal('show')
;
				
					});
		});
	
	