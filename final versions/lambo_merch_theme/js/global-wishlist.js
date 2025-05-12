/**
 * Global Wishlist Functions
 * This file provides global access to wishlist functionality across the site
 */

// Create the global LamboWishlist object
window.LamboWishlist = {
    // Get wishlist from localStorage or fallback to cookie
    getWishlist: function() {
        var wishlist = [];
        
        // First try to get from localStorage
        try {
            // Make sure we use the exact same key 'wishlist' across all functions
            var localStorageWishlist = localStorage.getItem('wishlist');
            console.log('Raw localStorage wishlist:', localStorageWishlist);
            
            if (localStorageWishlist) {
                try {
                    wishlist = JSON.parse(localStorageWishlist);
                    console.log('Parsed wishlist from localStorage:', wishlist);
                } catch (parseError) {
                    console.error('Error parsing localStorage wishlist:', parseError);
                    // Keep wishlist as an empty array if parsing fails
                }
                
                // Ensure we have an array
                if (!Array.isArray(wishlist)) {
                    console.error('localStorage wishlist is not an array:', wishlist);
                    wishlist = [];
                } else {
                    // Ensure all product IDs are strings for consistent comparison
                    wishlist = wishlist.map(function(item) {
                        var stringVal = item ? item.toString() : '';
                        console.log('Converting wishlist item to string:', item, '->', stringVal);
                        return stringVal;
                    });
                    console.log('Normalized wishlist (all strings):', wishlist);
                }
            } else {
                console.log('No wishlist found in localStorage');
            }
        } catch (e) {
            console.error('Error accessing localStorage:', e);
            // Keep wishlist as empty array if access fails
        }
        
        // If no wishlist in localStorage, try cookie as fallback
        if (wishlist.length === 0 && document.cookie.indexOf('lambo_wishlist=') !== -1) {
            var cookieValue = document.cookie.split('; ').find(function(row) { 
                return row.startsWith('lambo_wishlist='); 
            });
            
            if (cookieValue) {
                try {
                    // Parse the cookie value
                    var cookieContent = decodeURIComponent(cookieValue.split('=')[1]);
                    console.log('Raw cookie content:', cookieContent);
                    
                    wishlist = JSON.parse(cookieContent);
                    
                    // Ensure we have an array
                    if (!Array.isArray(wishlist)) {
                        console.error('Wishlist is not an array:', wishlist);
                        wishlist = [];
                    } else {
                        // Ensure all product IDs are strings for consistent comparison
                        wishlist = wishlist.map(function(item) {
                            return item.toString();
                        });
                        
                        // If we got wishlist from cookie, also save to localStorage for future use
                        localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    }
                } catch (e) {
                    console.error('Error parsing wishlist cookie:', e);
                    wishlist = [];
                }
            }
        }
        
        return wishlist;
    },
    
    // Save wishlist to localStorage and cookie
    saveWishlist: function(wishlist) {
        // If input is not valid, try to read existing wishlist from localStorage
        if (!Array.isArray(wishlist)) {
            console.error('Invalid wishlist provided (not an array):', wishlist);
            
            try {
                var existing = localStorage.getItem('wishlist');
                if (existing) {
                    wishlist = JSON.parse(existing);
                    if (!Array.isArray(wishlist)) {
                        console.error('Existing wishlist is also invalid, resetting to empty array');
                        wishlist = [];
                    }
                } else {
                    wishlist = [];
                }
            } catch (e) {
                console.error('Error reading existing wishlist:', e);
                wishlist = [];
            }
        }
        
        // Ensure all product IDs are strings and valid
        wishlist = wishlist.filter(function(item) {
            return item !== null && item !== undefined;
        }).map(function(item) {
            return item.toString();
        });
        
        // Log what we're about to save
        console.log('About to save wishlist:', wishlist);
        
        // Save to localStorage (primary storage)
        try {
            var wishlistJson = JSON.stringify(wishlist);
            localStorage.setItem('wishlist', wishlistJson);
            console.log('Wishlist saved to localStorage:', wishlist);
            
            // Verify the save was successful
            var savedRaw = localStorage.getItem('wishlist');
            console.log('Verification - raw saved wishlist:', savedRaw);
            if (savedRaw) {
                var savedParsed = JSON.parse(savedRaw);
                console.log('Verification - parsed saved wishlist:', savedParsed);
            }
        } catch (e) {
            console.error('Error saving to localStorage:', e);
        }
        
        // Also save to cookie for backward compatibility
        try {
            // Set cookie expiration for 30 days
            var date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
            
            // Set/update cookie with proper path and expiration
            var cookieString = 'lambo_wishlist=' + encodeURIComponent(wishlistJson) + 
                               '; expires=' + date.toUTCString() + 
                               '; path=/; SameSite=Lax';
            
            // Save cookie
            document.cookie = cookieString;
            console.log('Wishlist also saved to cookie for compatibility');
        } catch (e) {
            console.error('Error saving to cookie:', e);
        }
    },
    
    // Add a product to the wishlist
    addToWishlist: function(productId) {
        // Convert productId to string for consistent comparison
        productId = productId ? productId.toString() : '';
        console.log('Adding to wishlist, product ID:', productId);
        
        if (!productId) {
            this.showMessage('Error: Invalid product ID', 'error');
            return;
        }
        
        // Get current wishlist directly from localStorage
        var wishlist = [];
        try {
            var existing = localStorage.getItem('wishlist');
            console.log('Raw existing wishlist:', existing);
            
            if (existing) {
                try {
                    wishlist = JSON.parse(existing);
                } catch (parseError) {
                    console.error('Parse error:', parseError);
                    wishlist = [];
                }
                
                if (!Array.isArray(wishlist)) {
                    console.warn('Parsed wishlist is not an array, resetting:', wishlist);
                    wishlist = [];
                }
            } else {
                console.log('No existing wishlist, starting with empty array');
            }
        } catch (e) {
            console.error('Error reading from localStorage:', e);
        }
        
        // Convert all IDs to strings for consistent comparison
        wishlist = wishlist.map(function(id) {
            return id ? id.toString() : '';
        });
        
        console.log('Current wishlist before adding:', wishlist);
        
        // Check if product is already in wishlist
        if (wishlist.indexOf(productId) === -1) {
            // Add product to wishlist (as string)
            wishlist.push(productId);
            console.log('Product added, new wishlist:', wishlist);
            
            // Save directly to localStorage
            try {
                var wishlistJson = JSON.stringify(wishlist);
                localStorage.setItem('wishlist', wishlistJson);
                console.log('Updated wishlist saved to localStorage:', wishlistJson);
                
                // Verify save was successful
                var verification = localStorage.getItem('wishlist');
                console.log('Verification - localStorage now contains:', verification);
            } catch (e) {
                console.error('Error saving to localStorage:', e);
            }
            
            // Show success message
            this.showMessage('Product added to your favorites!', 'success');
            
            // Update wishlist count in header
            this.updateWishlistCount();
            
            // Send AJAX request to update server-side wishlist for logged-in users
            this.updateServerWishlist(wishlist);
            
            // Trigger a custom event that the wishlist was updated
            try {
                document.dispatchEvent(new Event('wishlist:updated'));
            } catch (e) {
                console.error('Error dispatching update event:', e);
            }
        } else {
            // Product already in wishlist
            this.showMessage('Product is already in your favorites!', 'info');
        }
    },
    
    // Remove a product from the wishlist
    removeFromWishlist: function(productId) {
        // Convert productId to string for consistent comparison
        productId = productId ? productId.toString() : '';
        console.log('Removing from wishlist, product ID:', productId);
        
        if (!productId) {
            this.showMessage('Error: Invalid product ID', 'error');
            return;
        }
        
        // Get current wishlist directly from localStorage
        var wishlist = [];
        try {
            var existing = localStorage.getItem('wishlist');
            console.log('Raw existing wishlist:', existing);
            
            if (existing) {
                try {
                    wishlist = JSON.parse(existing);
                } catch (parseError) {
                    console.error('Parse error:', parseError);
                    wishlist = [];
                }
                
                if (!Array.isArray(wishlist)) {
                    console.warn('Parsed wishlist is not an array, resetting:', wishlist);
                    wishlist = [];
                }
            } else {
                console.log('No existing wishlist, nothing to remove');
            }
        } catch (e) {
            console.error('Error reading from localStorage:', e);
        }
        
        // Convert all IDs to strings for consistent comparison
        wishlist = wishlist.map(function(id) {
            return id ? id.toString() : '';
        });
        
        console.log('Current wishlist before removal:', wishlist);
        
        // Convert productId to string for comparison
        var productIdStr = productId.toString();
        
        // Use filter to create a new array without the item to remove
        var newWishlist = wishlist.filter(function(item) {
            return item !== productIdStr;
        });
        
        // Check if an item was actually removed
        var itemRemoved = newWishlist.length < wishlist.length;
        console.log('Item removed?', itemRemoved);
        console.log('New wishlist after filtering:', newWishlist);
        
        // Save the updated wishlist to localStorage
        try {
            var wishlistJson = JSON.stringify(newWishlist);
            localStorage.setItem('wishlist', wishlistJson);
            console.log('Updated wishlist saved to localStorage:', wishlistJson);
            
            // Verify save was successful
            var verification = localStorage.getItem('wishlist');
            console.log('Verification - localStorage now contains:', verification);
        } catch (e) {
            console.error('Error saving to localStorage:', e);
        }
            
        // Then save to cookie for backward compatibility
        this.saveWishlist(newWishlist);
        
        if (itemRemoved) {
            // Show success message
            this.showMessage('Product removed from your favorites!', 'success');
        } else {
            // Item wasn't in the wishlist
            this.showMessage('Product was not in your favorites list', 'info');
        }
        
        // Update wishlist count in header
        this.updateWishlistCount();
        
        // Send AJAX request to update server-side wishlist for logged-in users
        this.updateServerWishlist(newWishlist);
        
        // Trigger a custom event that the wishlist was updated
        try {
            document.dispatchEvent(new Event('wishlist:updated'));
        } catch (e) {
            console.error('Error dispatching update event:', e);
        }
        
        // If on wishlist/favorites page, remove the item from the DOM
        if (itemRemoved) {
            var $cartItem = jQuery('.cart-item[data-product-id="' + productId + '"], .wishlist-product[data-product-id="' + productId + '"]');
            if ($cartItem.length) {
                console.log('Found DOM element to remove');
                var $mobileActions = $cartItem.next('.mobile-actions');
                
                $cartItem.fadeOut(300, function() {
                    $cartItem.remove();
                    if ($mobileActions.length) {
                        $mobileActions.remove();
                    }
                    
                    // If list becomes empty, show empty state
                    if (jQuery('.cart-item:visible, .wishlist-product:visible').length === 0) {
                        var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                            '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                            '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                            '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                            'Continue Shopping</a></div>';
                        
                        jQuery('.desktop-layout, .mobile-layout').html(emptyHtml);
                    }
                });
            } else {
                console.log('No matching DOM element found for product ID:', productId);
            }
        }
    },
    
    // Update server-side wishlist via AJAX
    updateServerWishlist: function(wishlist) {
        // Prepare the AJAX data
        var ajaxData = {
            action: 'lambo_update_user_wishlist',
            wishlist: wishlist
        };
        
        // Get the AJAX URL
        var ajaxUrl = (typeof lambo_wishlist_params !== 'undefined' && lambo_wishlist_params.ajaxurl) ? 
            lambo_wishlist_params.ajaxurl : (typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php');
        
        // Send the AJAX request
        jQuery.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: ajaxData,
            success: function(response) {
                console.log('Server wishlist update response:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error updating server wishlist:', error);
            }
        });
    },
    
    // Update wishlist count in header
    updateWishlistCount: function() {
        var count = this.getWishlist().length;
        jQuery('.wishlist-count').text(count > 0 ? count : '');
    },
    
    // Show notification message
    showMessage: function(message, type) {
        var $messageElement = jQuery('.lambo-wishlist-message');
        
        // If the message element doesn't exist, create it
        if ($messageElement.length === 0) {
            jQuery('body').append('<div class="lambo-wishlist-message"></div>');
            $messageElement = jQuery('.lambo-wishlist-message');
        }
        
        // Set the message content and style
        $messageElement
            .attr('class', 'lambo-wishlist-message ' + type)
            .html(message)
            .fadeIn(300);
        
        // Auto-hide the message after 3 seconds
        clearTimeout(this.messageTimeout);
        this.messageTimeout = setTimeout(function() {
            $messageElement.fadeOut(300);
        }, 3000);
    }
};

// Initialize wishlist count on page load
jQuery(document).ready(function($) {
    // Update wishlist count in header
    LamboWishlist.updateWishlistCount();
    
    // Add direct click event handlers for add/remove wishlist buttons
    $(document).on('click', '.add-to-wishlist', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        console.log('Add to wishlist button clicked, product ID:', productId);
        LamboWishlist.addToWishlist(productId);
    });
    
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        console.log('Remove from wishlist button clicked, product ID:', productId);
        LamboWishlist.removeFromWishlist(productId);
    });
    
    console.log('Global wishlist functionality initialized');
});