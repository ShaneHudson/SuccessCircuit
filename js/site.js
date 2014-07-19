var lap_start = 481;
var desk_start = 1024;
jQuery(window).ready(function($) {
	//setBgColour();
	//setBorderColour();
});


function matches(src) {
	var players = ['www.youtube.com', 'player.vimeo.com'];
	return new RegExp('^(https?:)?\/\/(?:' + players.join('|') + ').*$', 'i').test(src);
};


jQuery(window).load(function($) {
	//content_grid();
	jQuery('iframe, embed').each(function()  {
		var match = matches(jQuery(this).attr('src'));
		if (match) jQuery(this).wrap('<div/>').parent().toggleClass("fluid-video", true);
	});
});

jQuery(window).resize(function($) {
	//content_grid();
});

function content_grid()  {
	if (jQuery('.grid-wrapper').width() > lap_start)	{
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
	jQuery(ele).each(function() {
		var height = jQuery(this).innerHeight();
		if (height > tallest)  {
			tallest = height;
		}
	});
	return tallest;
}

function setHeight(ele, height) {
	jQuery('a', ele).css('height', height);
}

function setBgColour()  {
	jQuery('.custom-bg[data-colour]').each(function() {
		var colour = jQuery(this).data('colour');
		jQuery(this).css('background-color', colour);
	});
}


function setBorderColour()  {
	jQuery('.custom_border[data-colour]').each(function() {
		var colour = jQuery(this).data('colour');
		jQuery(this).css('border-color', colour);
	});
}
