jQuery(document).ready(function($) {
    // Mobile menu toggle
    $('.menu-toggle, .mobile-menu-toggle').click(function(e) {
        e.preventDefault();
        $('body').toggleClass('menu-open');
    });
    
    // Close button for mobile menu
    $('.close-menu').click(function(e) {
        e.preventDefault();
        $('body').removeClass('menu-open');
    });
    
    // Email form focus effect
    $('.email-placeholder').click(function() {
        $(this).fadeOut(200, function() {
            $(this).siblings('input[type="email"]').focus();
            $(this).siblings('.arrow-btn').show();
        });
    });
    
    // Email form blur effect if empty
    $('input[type="email"]').blur(function() {
        if ($(this).val() === '') {
            $(this).siblings('.arrow-btn').hide();
            $(this).siblings('.email-placeholder').fadeIn(200);
        }
    });
    
    // Fixed header on scroll
    var $header = $('.site-header');
    var headerHeight = $header.outerHeight();
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $header.addClass('fixed');
            $('body').css('padding-top', headerHeight);
        } else {
            $header.removeClass('fixed');
            $('body').css('padding-top', 0);
        }
    });
    
    // Make sure links for search and wishlist work properly
    $('.header-icon-link.search-icon, .search-icon').click(function(e) {
        e.preventDefault();
        window.location.href = '/search';
    });
    
    // Wishlist link click handler
    $('a[href$="/wishlist"]').click(function(e) {
        e.preventDefault();
        window.location.href = '/wishlist';
    });
    
    // Product tabs
    $('.tab-link').click(function(e) {
        e.preventDefault();
        
        var tab_id = $(this).attr('data-tab');
        
        $('.tab-link').parent().removeClass('active');
        $('.tab-content').removeClass('active');
        
        $(this).parent().addClass('active');
        $("#"+tab_id).addClass('active');
    });
    
    // Quantity buttons
    $('.quantity-button.minus').click(function() {
        var input = $(this).siblings('input.qty');
        var val = parseInt(input.val());
        if (val > 1) {
            input.val(val - 1).change();
        }
    });
    
    $('.quantity-button.plus').click(function() {
        var input = $(this).siblings('input.qty');
        var val = parseInt(input.val());
        var max = parseInt(input.attr('max'));
        
        if (!max || val < max) {
            input.val(val + 1).change();
        }
    });
});