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
    
    if (is_user_logged_in()) {
        // Get wishlist from user meta
        $current_user_id = get_current_user_id();
        $wishlist_items = get_user_meta($current_user_id, 'lambo_wishlist', true);
        if (!is_array($wishlist_items)) {
            $wishlist_items = array();
        }
    } else {
        // Get wishlist from cookies
        if (isset($_COOKIE['lambo_wishlist'])) {
            $wishlist_items = json_decode(stripslashes($_COOKIE['lambo_wishlist']), true);
            if (!is_array($wishlist_items)) {
                $wishlist_items = array();
            }
        }
    }
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
                    <div class="cart-item" style="
                        background: #222222;
                        display: flex;
                        align-items: center;
                        padding: 1rem;
                        margin-bottom: 1rem;
                    " data-product-id="<?php echo esc_attr($product_id); ?>">
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
                    <div class="cart-item" style="
                        background: #222222;
                        display: flex;
                        align-items: center;
                        padding: 1rem;
                        margin-bottom: 1rem;
                    " data-product-id="<?php echo esc_attr($product_id); ?>">
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
    
    // Handle "Remove from Wishlist" button clicks
    $('.remove-from-wishlist').on('click', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const $itemElement = $(this).closest('.cart-item');
        const $mobileActionsElement = $itemElement.next('div');
        
        if (!productId) return;
        
        // Remove from wishlist with animation
        removeFromWishlist(productId, function() {
            $itemElement.fadeOut(300, function() {
                $itemElement.remove();
                
                if ($mobileActionsElement.length && $mobileActionsElement.css('margin-top') === '-1rem') {
                    $mobileActionsElement.remove();
                }
                
                // Check if wishlist is now empty
                if ($('.cart-item').length === 0) {
                    // Replace with empty wishlist message
                    const emptyHtml = `
                        <div style="text-align:center; padding:50px 0;">
                            <p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>
                            <a href="${woocommerce_params.shop_url || '<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>'}" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">
                                Continue Shopping
                            </a>
                        </div>
                    `;
                    $('.desktop-layout, .mobile-layout').html(emptyHtml);
                }
            });
        });
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
    
    // Function to remove item from wishlist
    function removeFromWishlist(productId, callback) {
        // Convert productId to string to ensure consistent comparison
        productId = productId.toString();
        
        // Get existing wishlist items
        var wishlist = [];
        
        // Check for cookie
        if (document.cookie.indexOf('lambo_wishlist=') !== -1) {
            var cookieValue = document.cookie.split('; ').find(row => row.startsWith('lambo_wishlist='));
            if (cookieValue) {
                try {
                    wishlist = JSON.parse(decodeURIComponent(cookieValue.split('=')[1]));
                } catch (e) {
                    wishlist = [];
                }
            }
        }
        
        // Find product in wishlist
        var index = wishlist.indexOf(productId);
        
        if (index !== -1) {
            // Remove product from wishlist
            wishlist.splice(index, 1);
            
            // Set cookie for 30 days
            var date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.cookie = 'lambo_wishlist=' + encodeURIComponent(JSON.stringify(wishlist)) + '; expires=' + date.toUTCString() + '; path=/';
            
            // If the user is logged in, also update the server-side wishlist
            if (typeof ajaxurl !== 'undefined') {
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'lambo_update_user_wishlist',
                        wishlist: wishlist,
                        security: typeof lambo_ajax !== 'undefined' ? lambo_ajax.nonce : ''
                    },
                    success: function() {
                        // Call the callback function after successful removal
                        if (typeof callback === 'function') {
                            callback();
                        }
                    },
                    error: function() {
                        // Call the callback function even if the server update fails
                        if (typeof callback === 'function') {
                            callback();
                        }
                    }
                });
            } else {
                // Call the callback function if not logged in
                if (typeof callback === 'function') {
                    callback();
                }
            }
        } else {
            // Item not found in wishlist, call callback anyway
            if (typeof callback === 'function') {
                callback();
            }
        }
    }
});
</script>

<?php get_footer(); ?>