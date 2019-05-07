

(function($){

  $('.grid').isotope({
    itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
    percentPosition: true,
    masonry: {
      columnWidth: '.grid-sizer'
    }
  });

})(jQuery);
