jQuery(function ($) {

    'use strict';

    // Search
    // Slick Slider
    // Countdown
    // Remove Item
    // MagnificPopup
    // Jquery Ui priceRange
    // Animationend

    // -------------------------------------------------------------
    // Search
    // -------------------------------------------------------------

    (function () {

        $(".search-icon").on('click', function() {
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened');
            $('.search-icon i').removeClass('active-search').addClass('fa-search');
            $('.search-form').fadeOut('slow').removeClass('').addClass('');
        } else {
            $(this).addClass('opened');
            $('.search-icon i').addClass('active-search').removeClass('fa-search');
            $(".search-form").fadeIn('slow').removeClass('').addClass('');
        }
        });
        $("body").on('click', function() {
            $('.search-icon').removeClass('opened');
            $('.search-icon i').removeClass('active-search').addClass('fa-search');
            $('.search-form').fadeOut('slow').removeClass('').addClass('');
        });
        $('.tr-search').on('click', function(e) {
            e.stopPropagation();
        });

    }()); 

 
    // -------------------------------------------------------------
    //  Slick Slider
    // -------------------------------------------------------------  

    (function() {
      
        $(".product-slider, .blog-slider").slick({
            infinite: true,
            dots: true,
            slidesToShow: 1,
            autoplay:true,
            autoplaySpeed:10000,
            slidesToScroll: 1       
        });
      
        $(".brand-slider").slick({
            infinite: true,
            dots: true,
            slidesToShow: 2,
            autoplay:true,
            autoplaySpeed:10000,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 475,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]       
        });                     

    }());

    // -------------------------------------------------------------
    //  Countdown
    // -------------------------------------------------------------

    (function () {

        $(".countdown").countdown({
            date: "29 aug 2018 12:00:00",
            format: "on"
        });

    }()); 

    // -------------------------------------------------------------
    //  Remove Item
    // -------------------------------------------------------------

    (function() {

        $( ".remove-icon" ).on('click', function() {
            $(this).parents('.remove-item').fadeOut();
        });

    }());  


    // -------------------------------------------------------------
    //  MagnificPopup
    // -------------------------------------------------------------

    (function () {

        $('.popup-one .image-link').magnificPopup({
          type: 'image',
          gallery:{
            enabled:true
          }
        }); 

        $('.popup-two .image-link').magnificPopup({
          type: 'image',
          gallery:{
            enabled:true
          }
        });        
        
        $('.video-link').magnificPopup({type:'iframe'});

    }());     


    // -------------------------------------------------------------
    //  Jquery Ui priceRange
    // -------------------------------------------------------------

    $( function() {
        
        $( "#price_slider" ).slider({
        range: true,
        min: 0,
        max: 1050,
        values: [ 0, 1050 ],
        slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
        });
        $( "#amount" ).val( "$" + $( "#price_slider" ).slider( "values", 0 ) +
        " - $" + $( "#price_slider" ).slider( "values", 1 ) );

    } );   

    // -------------------------------------------------------------
    //  Jquery Ui priceRange
    // -------------------------------------------------------------

    $( function() {

       $('#home-carousel').bsTouchSlider();

    } );   



  /*==============================================================*/
  // Animationend
  /*==============================================================*/

    (function( $ ) {

        //Function to animate slider captions 
        function doAnimations( elems ) {
            //Cache the animationend event in a variable
            var animEndEv = 'webkitAnimationEnd animationend';
            
            elems.each(function () {
                var $this = $(this),
                    $animationType = $this.data('animation');
                $this.addClass($animationType).one(animEndEv, function () {
                    $this.removeClass($animationType);
                });
            });
        }
        
        //Variables on page load 
        var $myCarousel = $('#home-carousel'),
            $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
            
        //Initialize carousel 
        $myCarousel.carousel();
        
        //Animate captions in first slide on page load 
        doAnimations($firstAnimatingElems);
        
        //Pause carousel  
        $myCarousel.carousel('pause');
        
        //Other slides to be animated on carousel slide event 
        $myCarousel.on('slide.bs.carousel', function (e) {
            var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
            doAnimations($animatingElems);
        });  
        
    })(jQuery);      
      

// script end
});