/**
 * Custom scripts for Lambo Merch theme
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Sticky header
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('sticky');
            } else {
                $('.site-header').removeClass('sticky');
            }
        });
        
        // Smooth scroll for anchor links
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                    return false;
                }
            }
        });
        
        // Initialize hero slider if it exists
        if ($('.hero-slider-container').length) {
            $('.hero-slider-container').slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                autoplay: true,
                autoplaySpeed: 5000
            });
        }
        
        // Initialize video modal
        $('.play-button').on('click', function(e) {
            e.preventDefault();
            var videoId = $(this).data('video-id');
            var videoUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            
            // Create modal
            var modal = $('<div class="video-modal"></div>');
            var modalContent = $('<div class="video-modal-content"></div>');
            var closeBtn = $('<span class="close-video">&times;</span>');
            var iframe = $('<iframe src="' + videoUrl + '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
            
            modalContent.append(closeBtn);
            modalContent.append(iframe);
            modal.append(modalContent);
            $('body').append(modal);
            
            // Close modal on click
            $('.close-video, .video-modal').on('click', function() {
                $('.video-modal').remove();
            });
            
            // Prevent closing when clicking inside the modal content
            $('.video-modal-content').on('click', function(e) {
                e.stopPropagation();
            });
        });
        
        // WooCommerce quantity buttons
        if ($('.quantity').length) {
            // Add plus and minus buttons
            $('.quantity').prepend('<button type="button" class="minus">-</button>');
            $('.quantity').append('<button type="button" class="plus">+</button>');
            
            // Plus button
            $('.quantity').on('click', '.plus', function() {
                var input = $(this).prev('input.qty');
                var val = parseInt(input.val());
                var step = input.attr('step');
                step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
                input.val(val + step).change();
            });
            
            // Minus button
            $('.quantity').on('click', '.minus', function() {
                var input = $(this).next('input.qty');
                var val = parseInt(input.val());
                var step = input.attr('step');
                step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
                if (val > 0) {
                    input.val(val - step).change();
                }
            });
        }
        
        // Product gallery image switcher
        $('.product-thumbnails img').on('click', function() {
            var imgSrc = $(this).attr('src');
            $('.product-main-image img').attr('src', imgSrc);
        });
        
        // Newsletter form validation
        $('.newsletter-form').on('submit', function(e) {
            var emailInput = $(this).find('input[type="email"]');
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailPattern.test(emailInput.val())) {
                e.preventDefault();
                emailInput.addClass('error');
                if (!emailInput.next('.error-message').length) {
                    emailInput.after('<span class="error-message">Please enter a valid email address</span>');
                }
            } else {
                emailInput.removeClass('error');
                emailInput.next('.error-message').remove();
            }
        });
        
        // Remove error class on input focus
        $('input.error').on('focus', function() {
            $(this).removeClass('error');
            $(this).next('.error-message').remove();
        });
    });
    
})(jQuery);
