var lap_start = 481;
var desk_start = 1024;
jQuery(window).ready(function($) {
	setBgColour();
	setBorderColour();
});

jQuery(window).load(function($) {
	content_grid();
});

jQuery(window).resize(function($) {
	content_grid();
});

function content_grid()  {
	if ($('.grid-wrapper').width() > lap_start)	{
		setHeight('.content-grid', 'auto');
		var height = getHeight('.content-grid a');
		setHeight('.content-grid', height);
	}
	else {
		setHeight('.content-grid', 'auto');
	}
}

function getHeight(ele) {
	var tallest = 0;
	$(ele).each(function() {
		var height = $(this).innerHeight();
		if (height > tallest)  {
			tallest = height;
		}
	});
	return tallest;
}

function setHeight(ele, height) {
	$('a', ele).css('height', height);
}

function setBgColour()  {
	$('.custom-bg[data-colour]').each(function() {
		var colour = $(this).data('colour');
		$(this).css('background-color', colour);
	});
}


function setBorderColour()  {
	$('.custom_border[data-colour]').each(function() {
		var colour = $(this).data('colour');
		$(this).css('border-color', colour);
	});
}