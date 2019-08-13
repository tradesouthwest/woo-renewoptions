    jQuery('a[href^="https://everlated.com/my-account/"]').on('click', 
    function(event) {
        var target = jQuery(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            jQuery('html', 'article').stop().animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    } );
