var lap_start = 481;
var desk_start = 1024;

function matches(src) {
	var players = ['www.youtube.com', 'player.vimeo.com'];
	return new RegExp('^(https?:)?\/\/(?:' + players.join('|') + ').*$', 'i').test(src);
};


jQuery(window).load(function($) {
	jQuery('iframe, embed').each(function()  {
		var match = matches(jQuery(this).attr('src'));
		if (match) jQuery(this).wrap('<div/>').parent().toggleClass("fluid-video", true);
	});
});
