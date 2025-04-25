<?php
/**
 * Template Name: Cart Page Template
 * Description: A custom cart page template for Lambo Merch.
 */

get_header();
?>
<main id="primary" class="site-main" style="max-width:1200px; margin:0 auto; padding:2rem;">
  <h1 class="page-title" style="text-align:center; margin-bottom:2rem; color:#ff0000;">Cart</h1>

  <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>

    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

      <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
        $_product       = $cart_item['data'];
        $variations     = $cart_item['variation'];
        $size_display   = '';
        foreach ( $variations as $var_key => $var_val ) {
          if ( stripos( $var_key, 'size' ) !== false ) {
            $size_display = $var_val;
            break;
          }
        }
      ?>
        <div class="cart-item" style="background:#222222; display:flex; align-items:center; padding:1rem; margin-bottom:1rem;">

          <!-- Thumbnail -->
          <div style="flex:0 0 50px;">
            <img src="<?php echo esc_url( wp_get_attachment_image_url( $_product->get_image_id(), 'thumbnail' ) ); ?>"
                 alt="<?php echo esc_attr( $_product->get_name() ); ?>"
                 style="width:100%; height:auto;" />
          </div>

          <!-- Details -->
          <div style="flex:1; margin-left:1rem; color:#fff;">
            <div style="font-size:1rem; font-weight:600;">
              <?php echo esc_html( $_product->get_name() ); ?>
            </div>
            <div style="color:#ccc; font-size:0.9rem;">
              Size: <?php echo esc_html( $size_display ); ?>
            </div>
          </div>

          <!-- Unit Price -->
          <div style="flex:0 0 80px; text-align:right; color:#fff;">
            <?php echo wc_price( $_product->get_price() ); ?>
          </div>

          <!-- Quantity Selector -->
          <div style="flex:0 0 140px; display:flex; align-items:center; justify-content:center;">
            <button type="button" class="quantity-decrement" style="background:none;border:none;cursor:pointer;">
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/minus.png"
                   alt="-" style="width:20px;" />
            </button>

            <input type="number"
                   name="cart[<?php echo $cart_item_key; ?>][qty]"
                   value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
                   class="quantity-box"
                   style="width:40px; text-align:center; background:#15191f; color:#fff; border:none; margin:0 0.5rem;" />

            <button type="button" class="quantity-increment" style="background:none;border:none;cursor:pointer;">
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/plus.png"
                   alt="+" style="width:20px;" />
            </button>
          </div>

          <!-- Remove -->
          <div style="flex:0 0 50px; text-align:center;">
            <?php $remove_url = esc_url( wc_get_cart_url() . '?remove_item=' . $cart_item_key . '&_wpnonce=' . wp_create_nonce( 'woocommerce-cart' ) ); ?>
            <a href="<?php echo $remove_url; ?>">
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/trash-can-icon.png"
                   alt="Remove" style="width:20px;" />
            </a>
          </div>

        </div>
      <?php endforeach; ?>

      <!-- Actions -->
      <div style="display:flex; align-items:center; margin-bottom:2rem;">
        <input type="text" name="coupon_code" placeholder="Coupon Code..."
               style="flex:1; padding:0.75rem; background:#222222; border:1px solid #333; color:#fff;" />
        <button type="submit" name="apply_coupon" class="button"
                style="margin-left:1rem; background:#222222; color:#fff; padding:0.75rem 1.5rem; border:none;">
          Apply Coupon
        </button>
        <button type="submit" name="update_cart" class="button"
                style="margin-left:1rem; background:#222222; color:#fff; padding:0.75rem 1.5rem; border:none;">
          Update Cart
        </button>
        <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="button"
           style="margin-left:1rem; background:#222222; color:#fff; padding:0.75rem 1.5rem; text-decoration:none;">
          Continue Shopping
        </a>
        <?php do_action( 'woocommerce_cart_actions' ); ?>
        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
      </div>

    </form>

    <!-- Cart Totals -->
    <div class="cart-totals" style="margin-top:2rem;">
      <h2 style="color:#fff; margin-bottom:1rem;">Cart Totals</h2>
      <div style="background:#222222; padding:1rem; text-align:left;">
        <p style="color:#fff; margin-bottom:0.5rem;">Cart Subtotal: <?php echo wc_price( WC()->cart->get_subtotal() ); ?></p>
        <p style="color:#fff; margin-bottom:0.5rem;">Shipping & Handling:</p>
        <?php wc_cart_totals_shipping_html(); ?>
        <p style="color:#ccc; font-size:0.9rem; margin-top:1rem;">
          Shipping options will be updated during checkout. <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
             style="text-decoration:underline; color:#fff;">Change address</a>
        </p>
      </div>
      <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout-button"
         style="display:block; margin-top:1rem; background:#ff0000; color:#fff; padding:1rem 2rem; text-align:center; text-decoration:none;">
        Checkout
      </a>
    </div>

  <?php else : ?>
    <p style="color:#fff; text-align:center;">Your cart is currently empty.</p>
  <?php endif; ?>

</main>

<!-- Quantity JS -->
<script>
  document.querySelectorAll('.quantity-decrement').forEach(btn => {
    btn.addEventListener('click', function() {
      const input = this.parentNode.querySelector('input.quantity-box');
      let val = parseInt(input.value) || 1;
      if (val > 1) input.value = val - 1;
    });
  });
  document.querySelectorAll('.quantity-increment').forEach(btn => {
    btn.addEventListener('click', function() {
      const input = this.parentNode.querySelector('input.quantity-box');
      let val = parseInt(input.value) || 0;
      input.value = val + 1;
    });
  });
</script>

<?php
get_footer();
?>
