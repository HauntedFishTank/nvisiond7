(function($) {
  Drupal.behaviors.nvision = {
    attach: function (context, settings) {
      // Run First
      var newHeight = ($('#navbar').height() - 62);
      $('body.site-status-message #hero-carousel').css({"padding-top": newHeight + 'px'});

      // Run on resize
      $(window).resize(function() {
        var newHeight = ($('#navbar').height() - 62);
        $('body.site-status-message #hero-carousel').css({"padding-top": newHeight + 'px'});
      });

    }

  };
})(jQuery);
