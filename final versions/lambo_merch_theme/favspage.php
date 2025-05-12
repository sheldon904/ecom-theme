<?php
/**
 * Template Name: Wishlist/Favs Page
 *
 * @package Lambo_Merch
 */

get_header(); 
?>

<style>
/* Mobile-specific styles */
@media (max-width: 767px) {
  .mobile-layout { display: block !important; }
  .desktop-layout { display: none !important; }
}

/* Desktop-specific styles */
@media (min-width: 768px) {
  .desktop-layout { display: block !important; }
  .mobile-layout { display: none !important; }
}

/* Favorites/Wishlist Styles */
.cart-item {
  transition: background-color 0.3s ease;
}

.cart-item:hover {
  background-color: #2a2a2a !important;
}

.fav-checkbox {
  accent-color: #ff0000;
}

.quantity-display {
  transition: background-color 0.3s ease;
}

.quantity-increment:hover img, 
.quantity-decrement:hover img {
  opacity: 0.8;
}

.remove-from-wishlist:hover img {
  opacity: 0.7;
}

.variation-select {
  background-color: #15191f !important;
  color: white !important;
  border: 1px solid #333 !important;
  border-radius: 0 !important;
  padding: 5px 10px !important;
  cursor: pointer !important;
  transition: border-color 0.3s ease !important;
  -webkit-appearance: none !important;
  -moz-appearance: none !important;
  appearance: none !important;
  background-image: url('http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/size%20down%20arrow.png') !important;
  background-repeat: no-repeat !important;
  background-position: right 10px center !important;
  background-size: 12px !important;
  padding-right: 30px !important;
}

.variation-select:focus {
  outline: none !important;
  border-color: #ff0000 !important;
}

#add-selected-to-cart, 
#add-selected-to-cart-mobile {
  transition: background-color 0.3s ease;
}

#add-selected-to-cart:hover, 
#add-selected-to-cart-mobile:hover {
  background-color: #cc0000 !important;
}
</style>

<main id="primary" class="site-main" style="max-width:1200px; margin:0 auto; padding:2rem;">
    <h1 class="page-title" style="text-align:center; margin-bottom:2rem; color:#ff0000; font-style:italic;">
        My Favorites
    </h1>
    
    <?php
    // Get wishlist items from cookies or user meta if logged in
    $wishlist_items = array();
    
    // Check all possible cookie names to be sure we find the wishlist items
    $possible_cookie_names = array('lambo_wishlist', 'wishlist');
    $wishlist_found = false;
    
    foreach ($possible_cookie_names as $cookie_name) {
        if (isset($_COOKIE[$cookie_name])) {
            error_log('Found cookie with name: ' . $cookie_name);
            
            // Try to decode the cookie value
            $cookie_data = stripslashes($_COOKIE[$cookie_name]);
            error_log('Raw cookie data: ' . $cookie_data);
            
            try {
                $decoded_items = json_decode($cookie_data, true);
                
                // Ensure we have an array
                if (is_array($decoded_items)) {
                    error_log('Successfully parsed cookie data into array with ' . count($decoded_items) . ' items');
                    $wishlist_items = $decoded_items;
                    $wishlist_found = true;
                    break; // Use the first valid cookie we find
                } else {
                    error_log('Decoded cookie data is not an array: ' . print_r($decoded_items, true));
                }
            } catch (Exception $e) {
                error_log('Error decoding cookie data: ' . $e->getMessage());
            }
        }
    }
    
    // If no cookie found, try user meta if logged in
    if (!$wishlist_found && is_user_logged_in()) {
        $current_user_id = get_current_user_id();
        $user_meta_wishlist = get_user_meta($current_user_id, 'lambo_wishlist', true);
        
        if (is_array($user_meta_wishlist)) {
            $wishlist_items = $user_meta_wishlist;
            $wishlist_found = true;
            error_log('Found wishlist in user meta with ' . count($wishlist_items) . ' items');
        }
    }
    
    // Ensure all product IDs are strings for consistency with JavaScript
    $normalized_wishlist = array();
    foreach ($wishlist_items as $item) {
        $normalized_wishlist[] = (string) $item;
    }
    $wishlist_items = $normalized_wishlist;
    error_log('Normalized wishlist: ' . print_r($wishlist_items, true));
    
    // Filter out invalid products that no longer exist
    $valid_wishlist_items = array();
    foreach ($wishlist_items as $product_id) {
        $product = wc_get_product($product_id);
        if ($product && $product->exists()) {
            $valid_wishlist_items[] = $product_id;
            error_log('Valid product found: ' . $product_id);
        } else {
            error_log('Invalid product ID: ' . $product_id);
        }
    }
    $wishlist_items = $valid_wishlist_items;
    
    // If the filtered list differs from the original, update the saved wishlist
    if (count($valid_wishlist_items) !== count($normalized_wishlist)) {
        error_log('Filtered out ' . (count($normalized_wishlist) - count($valid_wishlist_items)) . ' invalid products');
        
        if (is_user_logged_in()) {
            update_user_meta($current_user_id, 'lambo_wishlist', $valid_wishlist_items);
            error_log('Updated user meta with valid wishlist items');
        }
        
        // Set the cookie with the valid items
        $cookie_expiry = time() + (30 * 24 * 60 * 60); // 30 days
        setcookie('lambo_wishlist', json_encode($valid_wishlist_items), $cookie_expiry, '/');
        error_log('Updated lambo_wishlist cookie with valid items');
    }
    
    // Output additional debug info to console on page load
    ?>
    <script>
    console.log('========= FAVORITES PAGE LOAD DEBUG INFO =========');
    console.log('PHP Server-side wishlist items:', <?php echo json_encode($wishlist_items); ?>);
    console.log('Cookie exists:', document.cookie.indexOf('lambo_wishlist=') !== -1);
    
    // Parse cookie if it exists
    if (document.cookie.indexOf('lambo_wishlist=') !== -1) {
        try {
            var cookieValue = document.cookie.split('; ').find(function(row) { return row.startsWith('lambo_wishlist='); });
            if (cookieValue) {
                var decodedValue = decodeURIComponent(cookieValue.split('=')[1]);
                console.log('Raw cookie value:', decodedValue);
                console.log('Parsed cookie value:', JSON.parse(decodedValue));
            }
        } catch (e) {
            console.error('Error parsing wishlist cookie on page load:', e);
        }
    }
    console.log('==========================================');
    </script>
    <?php
    ?>
    
    <!-- DESKTOP LAYOUT -->
    <div class="desktop-layout">
        <?php if (!empty($wishlist_items)) : ?>
            <form id="favorites-form">
                <?php wp_nonce_field('lambo_add_to_cart_nonce', 'lambo_nonce'); ?>
                
                <?php foreach ($wishlist_items as $product_id) :
                    $product = wc_get_product($product_id);
                    
                    // Skip if product doesn't exist
                    if (!$product) {
                        continue;
                    }
                    
                    // Get variation data if it's a variable product
                    $variation_options = array();
                    $has_variations = false;
                    
                    if ($product->is_type('variable')) {
                        $variations = $product->get_available_variations();
                        $variation_attributes = $product->get_variation_attributes();
                        
                        if (!empty($variations)) {
                            $has_variations = true;
                            
                            // Create descriptive labels for each variation
                            foreach ($variations as $variation) {
                                $variation_id = $variation['variation_id'];
                                $variation_obj = wc_get_product($variation_id);
                                
                                if (!$variation_obj) continue;
                                
                                // Start with the variation name or use product name as fallback
                                $variation_name = $variation_obj->get_name();
                                if (empty($variation_name)) {
                                    $variation_name = $product->get_name();
                                }
                                
                                // Build a descriptive label based on attributes
                                $attr_labels = array();
                                foreach ($variation['attributes'] as $attr_key => $attr_value) {
                                    if (empty($attr_value)) continue;
                                    
                                    // Convert attribute_pa_size to pa_size
                                    $clean_key = str_replace('attribute_', '', $attr_key);
                                    
                                    // Try to get the attribute label
                                    $taxonomy = strpos($clean_key, 'pa_') === 0 ? $clean_key : 'pa_' . $clean_key;
                                    
                                    // Try both taxonomy and plain attribute
                                    if (taxonomy_exists($taxonomy)) {
                                        $term = get_term_by('slug', $attr_value, $taxonomy);
                                        if ($term) {
                                            $attr_labels[] = $term->name;
                                        } else {
                                            $attr_labels[] = $attr_value;
                                        }
                                    } else {
                                        // If this is not a taxonomy, just use the value
                                        $attr_labels[] = $attr_value;
                                    }
                                }
                                
                                if (!empty($attr_labels)) {
                                    $variation_options[$variation_id] = implode(' - ', $attr_labels);
                                } else {
                                    // Fallback if no attributes are found
                                    $sku = $variation_obj->get_sku();
                                    if (!empty($sku)) {
                                        $variation_options[$variation_id] = "SKU: " . $sku;
                                    } else {
                                        $variation_options[$variation_id] = "Variation #" . $variation_id;
                                    }
                                }
                            }
                        }
                    }
                ?>
                    <div class="cart-item wishlist-product" style="
                        background: #222222;
                        display: flex;
                        align-items: center;
                        padding: 1rem;
                        margin-bottom: 1rem;
                    " data-product-id="<?php echo esc_attr($product_id); ?>" data-id-type="<?php echo gettype($product_id); ?>">
                        <!-- Debug: Product ID: <?php echo esc_attr($product_id); ?> (<?php echo gettype($product_id); ?>) -->
                        <!-- Checkbox -->
                        <div style="flex: 0 0 30px; text-align: center;">
                            <input type="checkbox" name="selected_products[]" value="<?php echo esc_attr($product_id); ?>" class="fav-checkbox" style="width: 20px; height: 20px;">
                        </div>
                        
                        <!-- Thumbnail -->
                        <div style="flex: 0 0 50px;">
                            <?php echo $product->get_image([80,80]); ?>
                        </div>
                        
                        <!-- Name & Size -->
                        <div style="flex:1; margin-left:1rem; color:#fff;">
                            <div style="font-weight:600;">
                                <?php echo esc_html($product->get_name()); ?>
                            </div>
                            <?php if ($product->is_type('variable') && !empty($variation_options)) : ?>
                                <div style="color:#ccc; font-size:0.9rem; margin-top: 0.5rem; display: flex; align-items: center;">
                                    <span style="margin-right: 0.5rem;">Variant:</span>
                                    <select class="variation-select" name="variation_id[<?php echo esc_attr($product_id); ?>]" style="background-color: #15191f; color: white; border: 1px solid #333; padding: 5px; max-width: 200px;">
                                        <?php foreach ($variation_options as $variation_id => $variation_name) : ?>
                                            <option value="<?php echo esc_attr($variation_id); ?>"><?php echo esc_html($variation_name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Unit Price -->
                        <div style="flex:0 0 80px; text-align:right; color:#ff0000;">
                            <?php echo $product->get_price_html(); ?>
                        </div>

                        <!-- Quantity Controls -->
                        <div style="flex:0 0 140px; display:flex; align-items:center; justify-content:center;">
                            <button type="button" class="quantity-decrement" style="background:none;border:none;cursor:pointer;">
                                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/minus.png" alt="–" style="width:20px;">
                            </button>
                            <span class="quantity-display" style="
                                width:40px;
                                text-align:center;
                                background:#15191f;
                                color:#fff;
                                display:inline-block;
                                margin:0 0.5rem;
                            ">
                                1
                            </span>
                            <input type="hidden"
                                   name="quantity[<?php echo esc_attr($product_id); ?>]"
                                   class="quantity-input"
                                   value="1" />
                            <button type="button" class="quantity-increment" style="background:none;border:none;cursor:pointer;">
                                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/plus.png" alt="+" style="width:20px;">
                            </button>
                        </div>
                        
                        <!-- Remove -->
                        <div style="flex:0 0 50px; text-align:center;">
                            <button type="button" class="remove-from-wishlist" data-product-id="<?php echo esc_attr($product_id); ?>" style="background:none; border:none; cursor:pointer;">
                                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/trash-can-icon.png" alt="Remove" style="width:20px;">
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- Add to Cart Button -->
                <div style="margin-top: 2rem; text-align: center;">
                    <button type="button" id="add-selected-to-cart" class="button" style="background:#ff0000; color:#fff; padding:1rem 2rem; text-transform:uppercase; font-weight:bold; border:none;">
                        Add Selected to Cart
                    </button>
                    
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button" style="display:inline-block; margin-left:1rem; background:#222222; color:#fff; padding:1rem 2rem; text-transform:uppercase; text-decoration:none;">
                        Continue Shopping
                    </a>
                </div>
            </form>
        <?php else : ?>
            <div style="text-align:center; padding:50px 0;">
                <p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">
                    Continue Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
    <!-- end .desktop-layout -->
    
    <!-- MOBILE LAYOUT -->
    <div class="mobile-layout">
        <?php if (!empty($wishlist_items)) : ?>
            <form id="favorites-form-mobile">
                <?php wp_nonce_field('lambo_add_to_cart_nonce', 'lambo_nonce_mobile'); ?>
                
                <?php foreach ($wishlist_items as $product_id) :
                    $product = wc_get_product($product_id);
                    
                    // Skip if product doesn't exist
                    if (!$product) {
                        continue;
                    }
                    
                    // Get variation data if it's a variable product
                    $variation_options = array();
                    $has_variations = false;
                    
                    if ($product->is_type('variable')) {
                        $variations = $product->get_available_variations();
                        $variation_attributes = $product->get_variation_attributes();
                        
                        if (!empty($variations)) {
                            $has_variations = true;
                            
                            // Create descriptive labels for each variation
                            foreach ($variations as $variation) {
                                $variation_id = $variation['variation_id'];
                                $variation_obj = wc_get_product($variation_id);
                                
                                if (!$variation_obj) continue;
                                
                                // Start with the variation name or use product name as fallback
                                $variation_name = $variation_obj->get_name();
                                if (empty($variation_name)) {
                                    $variation_name = $product->get_name();
                                }
                                
                                // Build a descriptive label based on attributes
                                $attr_labels = array();
                                foreach ($variation['attributes'] as $attr_key => $attr_value) {
                                    if (empty($attr_value)) continue;
                                    
                                    // Convert attribute_pa_size to pa_size
                                    $clean_key = str_replace('attribute_', '', $attr_key);
                                    
                                    // Try to get the attribute label
                                    $taxonomy = strpos($clean_key, 'pa_') === 0 ? $clean_key : 'pa_' . $clean_key;
                                    
                                    // Try both taxonomy and plain attribute
                                    if (taxonomy_exists($taxonomy)) {
                                        $term = get_term_by('slug', $attr_value, $taxonomy);
                                        if ($term) {
                                            $attr_labels[] = $term->name;
                                        } else {
                                            $attr_labels[] = $attr_value;
                                        }
                                    } else {
                                        // If this is not a taxonomy, just use the value
                                        $attr_labels[] = $attr_value;
                                    }
                                }
                                
                                if (!empty($attr_labels)) {
                                    $variation_options[$variation_id] = implode(' - ', $attr_labels);
                                } else {
                                    // Fallback if no attributes are found
                                    $sku = $variation_obj->get_sku();
                                    if (!empty($sku)) {
                                        $variation_options[$variation_id] = "SKU: " . $sku;
                                    } else {
                                        $variation_options[$variation_id] = "Variation #" . $variation_id;
                                    }
                                }
                            }
                        }
                    }
                ?>
                    <div class="cart-item wishlist-product" style="
                        background: #222222;
                        display: flex;
                        align-items: center;
                        padding: 1rem;
                        margin-bottom: 1rem;
                    " data-product-id="<?php echo esc_attr($product_id); ?>" data-id-type="<?php echo gettype($product_id); ?>">
                        <!-- Debug: Product ID: <?php echo esc_attr($product_id); ?> (<?php echo gettype($product_id); ?>) -->
                        <!-- Checkbox -->
                        <div style="flex: 0 0 30px; text-align: center;">
                            <input type="checkbox" name="selected_products[]" value="<?php echo esc_attr($product_id); ?>" class="fav-checkbox" style="width: 20px; height: 20px;">
                        </div>
                        
                        <!-- Thumbnail -->
                        <div style="flex: 0 0 50px;">
                            <?php echo $product->get_image([80,80]); ?>
                        </div>
                        
                        <!-- Name & Size -->
                        <div style="flex:1; margin-left:1rem; color:#fff;">
                            <div style="font-weight:600;">
                                <?php echo esc_html($product->get_name()); ?>
                            </div>
                            <?php if ($product->is_type('variable') && !empty($variation_options)) : ?>
                                <div style="color:#ccc; font-size:0.9rem; margin-top: 0.5rem; display: flex; align-items: center;">
                                    <span style="margin-right: 0.5rem;">Variant:</span>
                                    <select class="variation-select" name="variation_id[<?php echo esc_attr($product_id); ?>]" style="background-color: #15191f; color: white; border: 1px solid #333; padding: 5px; max-width: 200px;">
                                        <?php foreach ($variation_options as $variation_id => $variation_name) : ?>
                                            <option value="<?php echo esc_attr($variation_id); ?>"><?php echo esc_html($variation_name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Mobile Actions -->
                    <div style="
                        background: #333333;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 0.5rem 1rem;
                        margin-top: -1rem;
                        margin-bottom: 1rem;
                    ">
                        <!-- Price -->
                        <div style="color:#ff0000; font-weight:bold;">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                        
                        <!-- Quantity Controls -->
                        <div style="display:flex; align-items:center;">
                            <button type="button" class="quantity-decrement" style="background:none;border:none;cursor:pointer;">
                                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/minus.png" alt="–" style="width:20px;">
                            </button>
                            <span class="quantity-display" style="
                                width:40px;
                                text-align:center;
                                background:#15191f;
                                color:#fff;
                                display:inline-block;
                                margin:0 0.5rem;
                            ">
                                1
                            </span>
                            <input type="hidden"
                                   name="quantity[<?php echo esc_attr($product_id); ?>]"
                                   class="quantity-input"
                                   value="1" />
                            <button type="button" class="quantity-increment" style="background:none;border:none;cursor:pointer;">
                                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/plus.png" alt="+" style="width:20px;">
                            </button>
                        </div>
                        
                        <!-- Remove -->
                        <div>
                            <button type="button" class="remove-from-wishlist" data-product-id="<?php echo esc_attr($product_id); ?>" style="background:none; border:none; cursor:pointer;">
                                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/trash-can-icon.png" alt="Remove" style="width:20px;">
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- Add to Cart Button - Mobile -->
                <div style="position: fixed; bottom: 0; left: 0; width: 100%; background: #111; padding: 1rem; box-shadow: 0 -2px 10px rgba(0,0,0,0.3); z-index: 999;">
                    <button type="button" id="add-selected-to-cart-mobile" class="button" style="width: 100%; background:#ff0000; color:#fff; padding:1rem; text-transform:uppercase; font-weight:bold; border:none;">
                        Add Selected to Cart
                    </button>
                    
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button" style="display:block; width: 100%; margin-top:0.5rem; background:#222222; color:#fff; padding:0.5rem; text-transform:uppercase; text-decoration:none; text-align:center;">
                        Continue Shopping
                    </a>
                </div>
                <!-- Extra space to account for fixed bottom buttons -->
                <div style="height: 120px;"></div>
            </form>
        <?php else : ?>
            <div style="text-align:center; padding:50px 0;">
                <p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">
                    Continue Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
    <!-- end .mobile-layout -->
</main>

<script>
// Initialize the nonce for AJAX requests
var lambo_ajax = {
    nonce: '<?php echo wp_create_nonce('lambo_add_to_cart_nonce'); ?>'
};

// Favorites page functionality
jQuery(document).ready(function($) {
    // Handle quantity increment/decrement
    $('.quantity-decrement').on('click', function() {
        const wrapper = $(this).closest('div');
        const input = wrapper.find('.quantity-input');
        const display = wrapper.find('.quantity-display');
        let val = parseInt(input.val(), 10) || 1;
        if (val > 1) val--;
        input.val(val);
        display.text(val);
    });
    
    $('.quantity-increment').on('click', function() {
        const wrapper = $(this).closest('div');
        const input = wrapper.find('.quantity-input');
        const display = wrapper.find('.quantity-display');
        let val = parseInt(input.val(), 10) || 0;
        val++;
        input.val(val);
        display.text(val);
    });
    
    // Handle "Add Selected to Cart" button clicks (desktop and mobile)
    $('#add-selected-to-cart, #add-selected-to-cart-mobile').on('click', function() {
        const isDesktop = $(this).attr('id') === 'add-selected-to-cart';
        const formSelector = isDesktop ? '#favorites-form' : '#favorites-form-mobile';
        const selectedCheckboxes = $(formSelector + ' input.fav-checkbox:checked');
        
        if (selectedCheckboxes.length === 0) {
            alert('Please select at least one product to add to cart.');
            return;
        }
        
        // Get all selected product IDs
        const productIds = [];
        const quantities = {};
        const variationIds = {};
        
        selectedCheckboxes.each(function() {
            const productId = $(this).val();
            productIds.push(productId);
            
            // Get the cart item element that contains this checkbox
            const $cartItem = $(this).closest('.cart-item');
            
            // Get the quantity for this product
            const $quantityInput = $cartItem.find('.quantity-input');
            const quantity = $quantityInput.length ? parseInt($quantityInput.val(), 10) : 1;
            quantities[productId] = quantity;
            
            // Get the variation ID for this product if it's a variable product
            const $variationSelect = $cartItem.find('.variation-select');
            if ($variationSelect.length) {
                const variationId = $variationSelect.val();
                if (variationId) {
                    variationIds[productId] = variationId;
                }
            }
        });
        
        // Disable button during processing
        const buttonText = $(this).text();
        $(this).text('Adding...').prop('disabled', true);
        
        // Add all selected products to cart
        addMultipleProductsToCart(productIds, $(this), buttonText, quantities, variationIds);
    });
    
    // Function to add multiple products to cart
    function addMultipleProductsToCart(productIds, $button, originalText, quantities, variationIds) {
        let addedCount = 0;
        let failedCount = 0;
        
        // Add products one by one
        function addNextProduct(index) {
            if (index >= productIds.length) {
                // All products processed
                if (failedCount > 0) {
                    alert(`${addedCount} products were added to your cart. ${failedCount} products could not be added.`);
                } else {
                    alert(`${addedCount} products were added to your cart.`);
                }
                
                // Reset button
                $button.text(originalText).prop('disabled', false);
                
                // Redirect to cart page
                window.location.href = '<?php echo esc_url(wc_get_cart_url()); ?>';
                return;
            }
            
            const productId = productIds[index];
            
            // Get quantity from passed quantities object or default to 1
            let quantity = quantities && quantities[productId] ? quantities[productId] : 1;
            
            // Get variation ID from passed variationIds object or default to 0
            let variationId = variationIds && variationIds[productId] ? variationIds[productId] : 0;
            
            // Debug info
            console.log(`Adding product: ${productId}, Quantity: ${quantity}, Variation: ${variationId}`);
            
            // Prepare the data for AJAX
            const data = {
                action: 'lambo_add_to_cart',
                product_id: productId,
                quantity: quantity,
                security: typeof lambo_ajax !== 'undefined' ? lambo_ajax.nonce : 
                         (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.nonce : '')
            };
            
            // Only add variation_id if it's not 0
            if (variationId && variationId > 0) {
                data.variation_id = variationId;
            }
            
            // Add current product to cart
            $.ajax({
                type: 'POST',
                url: typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.ajax_url : ajaxurl,
                data: data,
                success: function(response) {
                    console.log('Ajax response:', response);
                    if (response && response.success) {
                        addedCount++;
                        
                        // Update cart count in header if it exists
                        if (response.cart_count) {
                            $('.cart-count').text(response.cart_count);
                        }
                    } else {
                        failedCount++;
                        console.error('Failed to add product:', productId, 'Response:', response);
                    }
                    
                    // Process next product
                    addNextProduct(index + 1);
                },
                error: function(xhr, status, error) {
                    failedCount++;
                    console.error('Ajax error:', status, error, xhr.responseText);
                    // Process next product even if current one failed
                    addNextProduct(index + 1);
                }
            });
        }
        
        // Start the sequential process
        addNextProduct(0);
    }
});
</script>

<!-- Simple direct wishlist management script -->
<script>
jQuery(document).ready(function($) {
    // WISHLIST MANAGEMENT FUNCTIONALITY
    const WISHLIST_KEY = 'wishlist';  // Use a consistent key name

    // Get wishlist directly from localStorage
    function getWishlist() {
        try {
            const raw = localStorage.getItem(WISHLIST_KEY);
            console.log('Raw wishlist from localStorage:', raw);
            if (raw) {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) {
                    // Convert all IDs to strings for consistent comparison
                    return parsed.map(id => id ? id.toString() : '');
                }
            }
        } catch (e) {
            console.error('Error reading wishlist from localStorage:', e);
        }
        // Default to empty array if anything goes wrong
        return [];
    }

    // Save wishlist to localStorage and cookie
    function saveWishlist(wishlist) {
        console.log('Saving wishlist:', wishlist);
        if (!Array.isArray(wishlist)) {
            console.error('Invalid wishlist (not an array):', wishlist);
            wishlist = [];
        }

        // Convert all IDs to strings
        wishlist = wishlist.map(id => id ? id.toString() : '');

        // Save to localStorage
        try {
            localStorage.setItem(WISHLIST_KEY, JSON.stringify(wishlist));
            console.log('Wishlist saved to localStorage');
        } catch (e) {
            console.error('Error saving to localStorage:', e);
        }

        // Also save to cookie for server-side access
        try {
            // Set cookie for 30 days
            var date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
            var cookieString = 'lambo_wishlist=' + encodeURIComponent(JSON.stringify(wishlist)) +
                               '; expires=' + date.toUTCString() +
                               '; path=/; SameSite=Lax';
            document.cookie = cookieString;
            console.log('Wishlist saved to cookie');
        } catch (e) {
            console.error('Error saving to cookie:', e);
        }
    }

    // Handler for "Remove from wishlist" button
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();
        
        // Get product ID from button
        var productId = $(this).data('product-id');
        if (!productId) {
            console.error('Invalid product ID');
            return;
        }
        
        // Convert to string
        productId = productId.toString();
        console.log('Removing product from wishlist:', productId);
        
        // Get current wishlist
        var wishlist = getWishlist();
        console.log('Current wishlist:', wishlist);
        
        // Remove the product ID from the wishlist
        var updatedWishlist = wishlist.filter(function(id) {
            return id !== productId;
        });
        
        console.log('Updated wishlist after removal:', updatedWishlist);
        
        // Save the updated wishlist
        saveWishlist(updatedWishlist);
        
        // Remove the item from the DOM
        var $item = $(this).closest('.cart-item, .wishlist-product');
        var $mobileActions = $item.next('.mobile-actions');
        
        $item.fadeOut(300, function() {
            $item.remove();
            if ($mobileActions.length) {
                $mobileActions.remove();
            }
            
            // If list is now empty, show empty state
            if ($('.cart-item:visible, .wishlist-product:visible').length === 0) {
                var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                    '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                    '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                    '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                    'Continue Shopping</a></div>';
                
                $('.desktop-layout, .mobile-layout').html(emptyHtml);
            }
        });
        
        // Show success message
        if (typeof showMessage === 'function') {
            showMessage('Product removed from your favorites!', 'success');
        } else {
            alert('Product removed from your favorites!');
        }
    });

    // Initialize the wishlist by showing only items that are actually in it
    function initializeWishlist() {
        console.log('Initializing wishlist display');
        var wishlist = getWishlist();
        console.log('Current wishlist items:', wishlist);

        // Don't hide items by default, just verify they're in the wishlist
        if (wishlist.length === 0) {
            // If the wishlist is empty, show empty state
            console.log('Wishlist is empty, showing empty state');
            var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                'Continue Shopping</a></div>';
            
            $('.desktop-layout, .mobile-layout').html(emptyHtml);
            return;
        }

        // Otherwise, check that rendered items are actually in the wishlist
        // (this removes anything that might have been deleted elsewhere)
        $('.cart-item, .wishlist-product').each(function() {
            var $item = $(this);
            var itemId = $item.data('product-id');
            if (itemId !== undefined) {
                itemId = itemId.toString();
                if (wishlist.indexOf(itemId) === -1) {
                    // This item is not in the wishlist, remove it
                    console.log('Removing item not in wishlist:', itemId);
                    $item.remove();
                    
                    // Also remove any associated mobile actions
                    var $mobileActions = $item.next('.mobile-actions');
                    if ($mobileActions.length) {
                        $mobileActions.remove();
                    }
                } else {
                    // Item is in the wishlist, ensure it's visible
                    console.log('Showing item in wishlist:', itemId);
                    $item.show();
                }
            }
        });
        
        // After filtering, check if anything is left
        if ($('.cart-item:visible, .wishlist-product:visible').length === 0) {
            console.log('No visible items after filtering, showing empty state');
            var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                'Continue Shopping</a></div>';
            
            $('.desktop-layout, .mobile-layout').html(emptyHtml);
        }
    }

    // Show a notification message
    function showMessage(message, type) {
        var $messageElement = $('.lambo-wishlist-message');
        
        // If the message element doesn't exist, create it
        if ($messageElement.length === 0) {
            $('body').append('<div class="lambo-wishlist-message"></div>');
            $messageElement = $('.lambo-wishlist-message');
        }
        
        // Set the message content and style
        $messageElement
            .attr('class', 'lambo-wishlist-message ' + type)
            .html(message)
            .fadeIn(300);
        
        // Auto-hide the message after 3 seconds
        setTimeout(function() {
            $messageElement.fadeOut(300);
        }, 3000);
    }

    // Run initialization immediately and after a short delay
    initializeWishlist();
    setTimeout(initializeWishlist, 500);
});
</script>

<!-- Debug tool for localStorage wishlist -->
<div id="wishlist-debug" style="display: none; position: fixed; bottom: 10px; right: 10px; background: rgba(0,0,0,0.8); color: white; padding: 10px; max-width: 400px; z-index: 9999; font-family: monospace; font-size: 12px; border-radius: 5px; max-height: 300px; overflow: auto;">
    <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
        <strong>Wishlist Debug</strong>
        <span onclick="document.getElementById('wishlist-debug').style.display = 'none'" style="cursor: pointer;">&times;</span>
    </div>
    <div id="wishlist-debug-content"></div>
    <div style="margin-top: 10px;">
        <button onclick="window.debugWishlist()" style="background: #C8B100; border: none; padding: 5px; cursor: pointer; margin-right: 5px;">Refresh</button>
        <button onclick="localStorage.removeItem('wishlist'); window.debugWishlist();" style="background: #ff3333; border: none; padding: 5px; cursor: pointer; margin-right: 5px;">Clear Wishlist</button>
        <button onclick="window.addTestItem()" style="background: #33aa33; border: none; padding: 5px; cursor: pointer; margin-right: 5px;">Add Test Item</button>
        <button onclick="window.fixWishlist()" style="background: #3377ff; border: none; padding: 5px; cursor: pointer;">Fix Wishlist</button>
    </div>
</div>

<!-- Add a simple standalone localStorage helper script -->
<script>
// This is a completely standalone function to help troubleshoot localStorage issues
// It doesn't rely on any other code and uses simple direct localStorage access
(function() {
    // Expose a simple helper function to the global scope
    window.fixWishlist = function() {
        try {
            console.log('Running wishlist fix function...');
            
            // Check all possible localStorage keys
            var possibleKeys = ['wishlist', 'wis hlist', 'lambo_wishlist'];
            var allItems = [];
            
            // Collect items from all possible keys
            possibleKeys.forEach(function(key) {
                try {
                    var keyData = localStorage.getItem(key);
                    if (keyData) {
                        console.log('Found data in key:', key, keyData);
                        var parsed = JSON.parse(keyData);
                        if (Array.isArray(parsed)) {
                            // Add items to our collection
                            parsed.forEach(function(item) {
                                if (item !== null && item !== undefined) {
                                    // Convert to string and add if not already present
                                    var strItem = String(item);
                                    if (allItems.indexOf(strItem) === -1) {
                                        allItems.push(strItem);
                                    }
                                }
                            });
                        } else {
                            console.warn('Data in', key, 'is not an array:', parsed);
                        }
                    }
                } catch (e) {
                    console.error('Error processing key', key, e);
                }
            });
            
            console.log('Combined items from all sources:', allItems);
            
            // Clear all keys
            possibleKeys.forEach(function(key) {
                localStorage.removeItem(key);
                console.log('Removed key:', key);
            });
            
            // Save consolidated list to the correct key
            localStorage.setItem('wishlist', JSON.stringify(allItems));
            console.log('Saved consolidated wishlist to localStorage:', allItems);
            
            // Also save to cookie for server-side access
            try {
                // Set cookie for 30 days
                var date = new Date();
                date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
                var cookieString = 'lambo_wishlist=' + encodeURIComponent(JSON.stringify(allItems)) +
                                  '; expires=' + date.toUTCString() +
                                  '; path=/; SameSite=Lax';
                document.cookie = cookieString;
                console.log('Saved consolidated wishlist to cookie');
            } catch (e) {
                console.error('Error saving to cookie:', e);
            }
            
            // Verify it worked
            var verification = localStorage.getItem('wishlist');
            console.log('Verification - localStorage now contains:', verification);
            
            // Show a success message
            alert('Wishlist fixed! Current items: ' + (allItems.length ? allItems.join(', ') : 'none'));
            
            // Force page reload to show the updated wishlist
            window.location.reload();
        } catch (e) {
            console.error('Error fixing wishlist:', e);
            alert('Error fixing wishlist: ' + e.message);
        }
    };
    
    // Function to add a test product to the wishlist
    window.addTestItem = function() {
        try {
            // Get current wishlist
            var wishlist = [];
            try {
                var existing = localStorage.getItem('wishlist');
                wishlist = existing ? JSON.parse(existing) : [];
                if (!Array.isArray(wishlist)) {
                    wishlist = [];
                }
            } catch (e) {
                console.error('Error reading wishlist:', e);
            }
            
            // Generate a random ID (timestamp-based)
            var testId = 'test_' + Date.now();
            
            // Add to wishlist
            wishlist.push(testId);
            
            // Save back to localStorage
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            console.log('Added test item to wishlist:', testId, 'New list:', wishlist);
            
            // Also save to cookie
            try {
                var date = new Date();
                date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
                var cookieString = 'lambo_wishlist=' + encodeURIComponent(JSON.stringify(wishlist)) +
                                  '; expires=' + date.toUTCString() +
                                  '; path=/; SameSite=Lax';
                document.cookie = cookieString;
            } catch (e) {
                console.error('Error saving to cookie:', e);
            }
            
            // Show confirmation
            alert('Added test item: ' + testId + '\n\nNote: Since this is a test ID and not a real product, it won\'t appear in the wishlist, but it is stored in localStorage. Check the debug panel to verify.');
            
            // Refresh debug display
            if (typeof window.debugWishlist === 'function') {
                window.debugWishlist();
            }
        } catch (e) {
            console.error('Error adding test item:', e);
            alert('Error adding test item: ' + e.message);
        }
    };
    
    // Run the fix function automatically if the URL contains "fix_wishlist=1"
    if (window.location.search.indexOf('fix_wishlist=1') !== -1) {
        console.log('Auto-fixing wishlist because fix_wishlist=1 parameter is present');
        setTimeout(function() {
            window.fixWishlist();
        }, 500);
    }
})();
</script>

<script>
// Debug function to show wishlist state
window.debugWishlist = function() {
    var debugDiv = document.getElementById('wishlist-debug');
    var contentDiv = document.getElementById('wishlist-debug-content');
    
    debugDiv.style.display = 'block';
    
    var content = '';
    content += '<h4>localStorage Wishlist</h4>';
    
    try {
        // Check for wishlist in any possible key locations
        var rawStandard = localStorage.getItem('wishlist');
        var rawAlt = localStorage.getItem('wis hlist'); // Check for possible misnamed key
        var allKeys = [];
        
        // List all localStorage keys
        for (var i = 0; i < localStorage.length; i++) {
            allKeys.push(localStorage.key(i));
        }
        
        content += '<div><strong>All localStorage keys:</strong> ' + allKeys.join(', ') + '</div>';
        content += '<div><strong>Raw (wishlist):</strong> ' + (rawStandard || 'empty') + '</div>';
        
        if (rawAlt) {
            content += '<div><strong>Raw (wis hlist):</strong> ' + rawAlt + '</div>';
        }
        
        // Process standard wishlist key
        if (rawStandard) {
            var parsed = JSON.parse(rawStandard);
            content += '<div><strong>Parsed:</strong></div>';
            content += '<ul>';
            if (Array.isArray(parsed)) {
                if (parsed.length === 0) {
                    content += '<li>Empty array</li>';
                } else {
                    parsed.forEach(function(item, index) {
                        content += '<li>' + index + ': ' + item + ' (type: ' + typeof item + ')</li>';
                    });
                }
            } else {
                content += '<li>Not an array: ' + typeof parsed + '</li>';
            }
            content += '</ul>';
        }
        
        // Process alternate wishlist key if it exists
        if (rawAlt) {
            try {
                var parsedAlt = JSON.parse(rawAlt);
                content += '<div><strong>Parsed (wis hlist):</strong></div>';
                content += '<ul>';
                if (Array.isArray(parsedAlt)) {
                    if (parsedAlt.length === 0) {
                        content += '<li>Empty array</li>';
                    } else {
                        parsedAlt.forEach(function(item, index) {
                            content += '<li>' + index + ': ' + item + ' (type: ' + typeof item + ')</li>';
                        });
                    }
                } else {
                    content += '<li>Not an array: ' + typeof parsedAlt + '</li>';
                }
                content += '</ul>';
            } catch (e) {
                content += '<div style="color: red;">Error parsing alternate key: ' + e.message + '</div>';
            }
        }
    } catch (e) {
        content += '<div style="color: red;">Error: ' + e.message + '</div>';
    }
    
    content += '<h4>DOM Items</h4>';
    var items = document.querySelectorAll('.wishlist-product, .cart-item.wishlist-product');
    content += '<div>' + items.length + ' items found</div>';
    
    if (items.length > 0) {
        content += '<ul>';
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var id = item.dataset.productId;
            var visible = window.getComputedStyle(item).display !== 'none';
            content += '<li>ID: ' + id + ', Visible: ' + visible + ', Class: ' + item.className + '</li>';
        }
        content += '</ul>';
    }
    
    contentDiv.innerHTML = content;
};

// Function to add a test item to the wishlist
window.addTestItem = function() {
    try {
        var wishlist = localStorage.getItem('wishlist');
        var list = wishlist ? JSON.parse(wishlist) : [];
        
        if (!Array.isArray(list)) {
            list = [];
        }
        
        // Get timestamp as test ID
        var testId = Date.now().toString();
        list.push(testId);
        
        localStorage.setItem('wishlist', JSON.stringify(list));
        alert('Added test item: ' + testId);
        window.debugWishlist();
    } catch (e) {
        alert('Error adding test item: ' + e.message);
    }
};

// Add a keyboard shortcut to show/hide debug panel
document.addEventListener('keydown', function(e) {
    // Alt+D to toggle debug panel
    if (e.altKey && e.key === 'd') {
        var debugDiv = document.getElementById('wishlist-debug');
        if (debugDiv.style.display === 'none') {
            window.debugWishlist();
        } else {
            debugDiv.style.display = 'none';
        }
    }
});

// Initialize wishlist items visibility on page load
jQuery(document).ready(function($) {
    // Define a function to handle wishlist item visibility
    function updateWishlistItemVisibility() {
        console.log("Updating wishlist item visibility");
        
        // First try to get wishlist items from localStorage
        var currentWishlist = [];
        try {
            var localStorageWishlist = localStorage.getItem('wishlist');
            if (localStorageWishlist) {
                currentWishlist = JSON.parse(localStorageWishlist);
                console.log('Loaded wishlist from localStorage:', currentWishlist);
            }
        } catch (e) {
            console.error('Error accessing localStorage:', e);
        }
        
        // If no localStorage data, try the global LamboWishlist object
        if (currentWishlist.length === 0 && typeof LamboWishlist !== 'undefined') {
            currentWishlist = LamboWishlist.getWishlist();
            console.log('Loaded wishlist from LamboWishlist object:', currentWishlist);
        }
        
        if (currentWishlist.length === 0) {
            console.log('No wishlist items found, showing empty state');
            // No wishlist items found, show empty state
            var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                'Continue Shopping</a></div>';
            
            $('.desktop-layout, .mobile-layout').html(emptyHtml);
            return;
        }
        
        // Ensure all product IDs are strings for consistent comparison
        currentWishlist = currentWishlist.map(function(item) {
            return item.toString();
        });
        
        console.log('Filtered wishlist (all strings):', currentWishlist);
        
        // Get all wishlist items on the page
        var $wishlistItems = $('.wishlist-product, .cart-item');
        console.log('Found', $wishlistItems.length, 'wishlist items in DOM');
        
        if ($wishlistItems.length > 0) {
            var anyItemsVisible = false;
            
            // Loop through each item and check if it's in the wishlist
            $wishlistItems.each(function() {
                var $item = $(this);
                var itemId = $item.data('product-id');
                
                // Make sure itemId is a string and log it
                itemId = itemId ? itemId.toString() : '';
                
                console.log('Checking item ID:', itemId, ' (type: ' + typeof itemId + ')');
                console.log('Wishlist:', currentWishlist);
                
                // Check if the item ID is in the wishlist using some() for more flexible comparison
                var inWishlist = currentWishlist.some(function(wishlistId) {
                    return wishlistId.toString() === itemId;
                });
                
                console.log('Item in wishlist:', inWishlist);
                
                if (inWishlist) {
                    // Item is in wishlist, show it
                    $item.addClass('wishlist-active');
                    $item.css('display', 'flex'); // Force display in case CSS isn't loaded yet
                    anyItemsVisible = true;
                    console.log('Showing item:', itemId);
                } else {
                    // Item not in wishlist, ensure it stays hidden
                    $item.removeClass('wishlist-active');
                    $item.css('display', 'none'); // Force hide
                    console.log('Hiding item:', itemId);
                }
            });
            
            // If no items are visible after filtering, show empty state
            if (!anyItemsVisible) {
                console.log('No matching items in wishlist, showing empty state');
                var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                    '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                    '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                    '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                    'Continue Shopping</a></div>';
                
                $('.desktop-layout, .mobile-layout').html(emptyHtml);
            }
        }
    }
    
    // Run immediately and after a short delay to ensure everything is loaded
    updateWishlistItemVisibility();
    
    // Also watch for changes to localStorage
    window.addEventListener('storage', function(e) {
        if (e.key === 'wishlist') {
            console.log('localStorage wishlist changed, updating display');
            updateWishlistItemVisibility();
        }
    });
    
    // Add a custom event for wishlist updates
    document.addEventListener('wishlist:updated', function() {
        console.log('Wishlist update event detected, updating display');
        updateWishlistItemVisibility();
    });
    
    // Override the standard wishlist functions to trigger our custom event
    var originalAddToWishlist = LamboWishlist.addToWishlist;
    LamboWishlist.addToWishlist = function(productId) {
        originalAddToWishlist.call(LamboWishlist, productId);
        document.dispatchEvent(new Event('wishlist:updated'));
    };
    
    var originalRemoveFromWishlist = LamboWishlist.removeFromWishlist;
    LamboWishlist.removeFromWishlist = function(productId) {
        originalRemoveFromWishlist.call(LamboWishlist, productId);
        document.dispatchEvent(new Event('wishlist:updated'));
    };
    
    // Also check for updates every second (as a fallback)
    setInterval(function() {
        updateWishlistItemVisibility();
    }, 1000);
});
</script>

<?php get_footer(); ?>