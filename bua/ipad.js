function pick(which) {
	$('.section').each(function(index) {
		if($(this).attr('id') == which) {
			$(this).appendTo('#main-scroll');
		}
		else {
			$(this).appendTo('#attic');
		}
	});
	appendTo('#attic');

}

$(document).ready(function () {
	var myScroll = new iScroll('main-scroll');
	
	$('#nav a').each(function(index) {
		$(this).click(function() {
			var loc = $(this).attr('id').indexOf('link-');
			if (loc > -1) {
				var section = $(this).attr('id').slice(loc+5);
				pick(section);
			}
		});
	});

	$('#attic').hide();
	$('#link-header').click();
});

