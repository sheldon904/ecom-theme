jQuery(document).ready(function($) {
    // Desktop and mobile menu toggle
    $('.menu-toggle, .mobile-menu-toggle').click(function(e) {
        e.preventDefault();
        $('body').toggleClass('menu-open');
        $('#site-navigation').toggleClass('toggled');
    });
    
    // Close button for menu
    $('.close-menu').click(function(e) {
        e.preventDefault();
        $('body').removeClass('menu-open');
        $('#site-navigation').removeClass('toggled');
    });
    
    // Email form focus effect
    $('.email-placeholder').click(function() {
        var $emailWrap = $(this).closest('.email-input-wrap');
        $(this).css('opacity', '0'); // Hide placeholder on click
        $emailWrap.find('input[type="email"]').focus();
    });
    
    // Direct focus on email input
    $('.email-input-wrap input[type="email"]').focus(function() {
        $(this).closest('.email-input-wrap').find('.email-placeholder').css('opacity', '0'); // Hide placeholder
    });
    
    // Email form blur effect if empty
    $('input[type="email"]').blur(function() {
        if ($(this).val() === '') {
            $(this).closest('.email-input-wrap').find('.email-placeholder').css('opacity', '1'); // Show placeholder
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
    
    // Toggle FiboSearch dropdown on click
    $('.header-icon-link.search-icon, .search-icon').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('active');
    });
    
    // Close FiboSearch dropdown when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('.search-icon').length) {
            $('.search-icon').removeClass('active');
        }
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