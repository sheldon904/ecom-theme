<?php
/**
 * Simple Favorites System
 * A straightforward implementation of product favorites
 */

// Don't allow direct access to this file
defined('ABSPATH') || exit;

/**
 * Simple Toggle Favorite function
 * Takes a product ID and visitor ID and toggles the favorite status
 */
function simple_toggle_favorite() {
    // Check for product ID
    if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
        wp_send_json_error(array('message' => 'Missing product ID'));
        return;
    }
    
    // Check for visitor ID
    if (!isset($_POST['visitor_id']) || empty($_POST['visitor_id'])) {
        wp_send_json_error(array('message' => 'Missing visitor ID'));
        return;
    }
    
    // Get the product ID
    $product_id = absint($_POST['product_id']);
    
    // Get the visitor ID
    $visitor_id = sanitize_text_field($_POST['visitor_id']);
    
    // Generate a unique meta key for this visitor
    $user_id = is_user_logged_in() ? 'user_' . get_current_user_id() : 'visitor_' . $visitor_id;
    $meta_key = 'favorite_' . $user_id;
    
    // Check if we're forcing removal
    $force_remove = isset($_POST['remove']) && $_POST['remove'] === 'true';
    
    // Get current favorite status
    $is_favorite = get_post_meta($product_id, $meta_key, true) == '1';
    
    // Log current status
    error_log(sprintf(
        'Product %d is %sfavorite for user %s',
        $product_id,
        $is_favorite ? '' : 'not ',
        $user_id
    ));
    
    // Toggle the status (or force remove)
    if ($is_favorite || $force_remove) {
        // Remove favorite status
        delete_post_meta($product_id, $meta_key);
        $is_favorite = false;
        $message = 'Product removed from favorites';
    } else {
        // Add favorite status
        update_post_meta($product_id, $meta_key, '1');
        $is_favorite = true;
        $message = 'Product added to favorites';
    }
    
    // Log the update
    error_log(sprintf(
        'Updated: Product %d is now %sfavorite for user %s',
        $product_id,
        $is_favorite ? '' : 'not ',
        $user_id
    ));
    
    // Return the result
    wp_send_json_success(array(
        'message' => $message,
        'is_favorite' => $is_favorite,
        'product_id' => $product_id,
        'user_id' => $user_id
    ));
}
add_action('wp_ajax_simple_toggle_favorite', 'simple_toggle_favorite');
add_action('wp_ajax_nopriv_simple_toggle_favorite', 'simple_toggle_favorite');

/**
 * Simple Check Favorite function
 * Check if a product is favorited by a specific visitor
 */
function simple_check_favorite() {
    // Check for product ID
    if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
        wp_send_json_error(array('message' => 'Missing product ID'));
        return;
    }
    
    // Check for visitor ID
    if (!isset($_POST['visitor_id']) || empty($_POST['visitor_id'])) {
        wp_send_json_error(array('message' => 'Missing visitor ID'));
        return;
    }
    
    // Get the product ID
    $product_id = absint($_POST['product_id']);
    
    // Get the visitor ID
    $visitor_id = sanitize_text_field($_POST['visitor_id']);
    
    // Generate a unique meta key for this visitor
    $user_id = is_user_logged_in() ? 'user_' . get_current_user_id() : 'visitor_' . $visitor_id;
    $meta_key = 'favorite_' . $user_id;
    
    // Get current favorite status
    $is_favorite = get_post_meta($product_id, $meta_key, true) == '1';
    
    // Return the result
    wp_send_json_success(array(
        'is_favorite' => $is_favorite,
        'product_id' => $product_id,
        'user_id' => $user_id,
        'meta_key' => $meta_key,
        'meta_value' => get_post_meta($product_id, $meta_key, true)
    ));
}
add_action('wp_ajax_simple_check_favorite', 'simple_check_favorite');
add_action('wp_ajax_nopriv_simple_check_favorite', 'simple_check_favorite');

/**
 * Function to check if a product is a favorite
 * Can be used in templates
 */
function is_product_favorite($product_id) {
    // Get visitor ID from cookie
    $visitor_id = isset($_COOKIE['lambo_visitor_id']) ? $_COOKIE['lambo_visitor_id'] : '';
    
    // Generate user ID
    $user_id = is_user_logged_in() ? 'user_' . get_current_user_id() : 'visitor_' . $visitor_id;
    
    // Generate meta key
    $meta_key = 'favorite_' . $user_id;
    
    // Check meta value
    return get_post_meta($product_id, $meta_key, true) == '1';
}