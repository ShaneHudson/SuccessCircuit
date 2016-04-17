(function($) {
  $.fn.imagefit = function(contain) {
    this.each( function() {
      var $this           = $(this),
          $wrapper        = $this.parent(),
          wrapper_width   = $wrapper.width(),
          wrapper_height  = $wrapper.height(),
          wrapper_ratio,
          image_ratio;

       
        // ratios
      image_ratio   = $this.width() / $this.height();
      wrapper_ratio = wrapper_width / wrapper_height;
        
      var ratio_cond = wrapper_ratio > image_ratio;
        if(contain) {
            ratio_cond = !ratio_cond;
        }

      if ( ratio_cond ) {
          $wrapper.css({
            'background'  : 'url('+$this.get(0).src+')',
            'background-size'  : '100% auto',
            'background-position'  : '0px 50%',
            'background-repeat'  : 'no-repeat',
			'background-color' : 'transparent',
			'background-size' : 'cover'
          });
      } else {
          $wrapper.css({
            'background'  : 'url('+$this.get(0).src+')',
            'background-size'  : 'auto 100%',
            'background-position'  : '50% 0px',
            'background-repeat'  : 'no-repeat',
			'background-color' : 'transparent',
			'background-size' : 'cover'
          });
      }

      $this.remove();
        
    });
    return this;
  };
    
  $('.content-grid__img').imagefit(true);               
    
}(jQuery));
