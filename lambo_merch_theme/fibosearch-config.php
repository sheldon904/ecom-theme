<?php
/**
 * FiboSearch Configuration Functions
 * Include this file in functions.php
 */

// Add action hooks for all functions
add_action('init', 'lambo_merch_fibosearch_config');
add_action('template_redirect', 'lambo_merch_handle_fibosearch_redirect', 5);
add_action('init', 'lambo_merch_register_search_pages');
add_filter('pre_get_posts', 'lambo_merch_search_products');

/**
 * Additional FiboSearch configuration and fixes
 */
function lambo_merch_fibosearch_config() {
    // Only proceed if FiboSearch is active
    if (!function_exists('dgwt_wcas_get_settings')) {
        return;
    }
    
    // 1. Set search results page to our custom template
    add_filter('dgwt/wcas/settings/load_value/key=search_results_page', function($value) {
        $page = get_page_by_path('fibosearch-results');
        if ($page) {
            return $page->ID;
        }
        return $value;
    });
    
    // 2. Disable FiboSearch form AJAX submission to use standard form with our redirection
    add_filter('dgwt/wcas/scripts/use_ajax_for_form_submission', '__return_false');

    // 3. Add custom class to FiboSearch form for easier styling
    add_filter('dgwt/wcas/form/classes', function($classes) {
        $classes[] = 'lambo-fibosearch-form';
        return $classes;
    });
    
    // 4. Increase number of suggestions shown
    add_filter('dgwt/wcas/settings/load_value/key=suggestions_limit', function() {
        return 10; // Show 10 search suggestions
    });
    
    // 5. Make sure form redirection works properly
    add_filter('dgwt/wcas/form/action', function($action) {
        return home_url('/'); // Base form action to home URL
    });

    // 6. Add hidden fields to ensure search works
    add_action('dgwt/wcas/search_form/after', function() {
        echo '<input type="hidden" name="post_type" value="product">';
    });
    
    // 7. Fix FiboSearch enter key behavior
    add_filter('dgwt/wcas/scripts/disable_submit', '__return_false');
}

// Handle FiboSearch redirections to prevent critical errors
function lambo_merch_handle_fibosearch_redirect() {
    // Check if this is a FiboSearch query
    if (isset($_GET['dgwt_wcas']) && isset($_GET['s'])) {
        // Get the search query
        $search_query = sanitize_text_field($_GET['s']);
        $post_type = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : 'product';
        
        // First, try to find the FiboSearch results page
        $fibo_page = get_page_by_path('fibosearch-results');
        
        if ($fibo_page) {
            // Use the FiboSearch results page
            $search_page_url = get_permalink($fibo_page->ID);
        } else {
            // Fallback to search debug page
            $debug_page = get_page_by_path('search-debug');
            if ($debug_page) {
                $search_page_url = get_permalink($debug_page->ID);
            } else {
                // Last resort - standard search page
                $search_page_url = home_url('/search-2/');
            }
        }
        
        // Build redirect URL with search parameters
        $redirect_url = add_query_arg(array(
            's' => $search_query,
            'post_type' => $post_type,
            'dgwt_search' => '1', // Mark as coming from FiboSearch
        ), $search_page_url);
        
        wp_safe_redirect($redirect_url);
        exit;
    }
}

// Register search templates as pages in WordPress
function lambo_merch_register_search_pages() {
    // Check if fibosearch-results page exists
    $fibo_page = get_page_by_path('fibosearch-results');
    if (!$fibo_page) {
        // Create FiboSearch results page
        wp_insert_post(array(
            'post_title'     => 'FiboSearch Results',
            'post_name'      => 'fibosearch-results',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template'  => 'fibosearch-results.php',
        ));
    }
    
    // Check if search-debug page exists
    $debug_page = get_page_by_path('search-debug');
    if (!$debug_page) {
        // Create search debug page
        wp_insert_post(array(
            'post_title'     => 'Search Debug',
            'post_name'      => 'search-debug',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template'  => 'search-debug.php',
        ));
    }
}

// Add pre_get_posts filter to handle search queries
function lambo_merch_search_products($query) {
    // Only modify search queries on the frontend
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        // Set post_type to product for all searches coming from FiboSearch
        if (isset($_GET['dgwt_wcas']) || isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
            $query->set('post_type', 'product');
            
            // Add product visibility taxonomy filter for better results
            $tax_query = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'exclude-from-search',
                    'operator' => 'NOT IN',
                ),
            );
            $query->set('tax_query', $tax_query);
        }
    }
    return $query;
}