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
    
    // Simple, reliable search functionality - final version
    
    // Store original button content
    var $desktopSearchBtn = $('.header-icon-link.search-icon');
    var $mobileSearchBtn = $('.mobile-header .search-icon');
    var desktopSearchOriginal = $desktopSearchBtn.html();
    var mobileSearchOriginal = $mobileSearchBtn.html();
    
    // Track search state
    var desktopSearchActive = false;
    var mobileSearchActive = false;
    
    // Desktop search toggle
    $desktopSearchBtn.click(function(e) {
        e.preventDefault();
        
        if (!desktopSearchActive) {
            // Replace button with search form
            $(this).html('<form role="search" method="get" class="header-search-form">' +
                '<input type="search" class="search-field" placeholder="Search products..." value="" name="s" />' +
                '<input type="hidden" name="post_type" value="product" />' +
                '</form>');
            
            $(this).find('.search-field').focus();
            desktopSearchActive = true;
        }
    });
    
    // Mobile search toggle
    $mobileSearchBtn.click(function(e) {
        e.preventDefault();
        
        if (!mobileSearchActive) {
            // Replace button with search form
            $(this).html('<form role="search" method="get" class="mobile-search-form">' +
                '<input type="search" class="search-field" placeholder="Search..." value="" name="s" />' +
                '<input type="hidden" name="post_type" value="product" />' +
                '</form>');
            
            $(this).find('.search-field').focus();
            mobileSearchActive = true;
        }
    });
    
    // Restore search button when clicking elsewhere
    $(document).on('click', function(e) {
        if (desktopSearchActive && !$(e.target).closest('.header-icon-link.search-icon').length) {
            $desktopSearchBtn.html(desktopSearchOriginal);
            desktopSearchActive = false;
        }
        
        if (mobileSearchActive && !$(e.target).closest('.mobile-header .search-icon').length) {
            $mobileSearchBtn.html(mobileSearchOriginal);
            mobileSearchActive = false;
        }
    });
    
    // Stop propagation for clicks inside the search form
    $(document).on('click', '.header-search-form, .mobile-search-form', function(e) {
        e.stopPropagation();
    });
    
    // Submit form on Enter key
    $(document).on('keydown', '.search-field', function(e) {
        if (e.keyCode === 13) {
            // Get the form element
            var $form = $(this).closest('form');
            
            // Get the search term
            var searchTerm = $(this).val();
            
            // Redirect to search page with parameters
            window.location.href = site_url + '?s=' + encodeURIComponent(searchTerm) + '&post_type=product';
            
            // Prevent default form submission
            return false;
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