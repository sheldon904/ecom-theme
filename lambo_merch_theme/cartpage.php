<?php
/**
 * Template Name: Cart Page Template
 * Description: A custom cart page template for Lambo Merch.
 */

defined( 'ABSPATH' ) || exit;

get_header();

// Remove any “added to cart” notice
wc_clear_notices();

// We no longer use server-side mobile detection; CSS will handle which layout to show.
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
</style>

<main id="primary" class="site-main" style="max-width:1200px; margin:0 auto; padding:2rem;">

  <!-- DESKTOP LAYOUT (unchanged contents of cartpageold.php) -->
  <div class="desktop-layout">
    <h1 class="page-title" style="text-align:center; margin-bottom:2rem; color:#ff0000; font-style:italic;">
      Cart
    </h1>

    <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>

      <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
          $_product   = $cart_item['data'];
          $quantity   = $cart_item['quantity'];
          // grab “size” variation if present
          $size_display = '';
          if ( $cart_item['variation_id'] && ! empty( $cart_item['variation'] ) ) {
            foreach ( $cart_item['variation'] as $attr => $val ) {
              if ( stripos( $attr, 'size' ) !== false ) {
                $size_display = $val;
                break;
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
          ">
            <!-- Thumbnail -->
            <div style="flex: 0 0 50px;">
              <?php echo $_product->get_image( [80,80] ); ?>
            </div>

            <!-- Name & Size -->
            <div style="flex:1; margin-left:1rem; color:#fff;">
              <div style="font-weight:600;">
                <?php echo esc_html( $_product->get_name() ); ?>
              </div>
              <?php if ( $size_display ) : ?>
                <div style="color:#ccc; font-size:0.9rem;">
                  Size: <?php echo esc_html( $size_display ); ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Unit Price -->
            <div style="flex:0 0 80px; text-align:right; color:#fff;">
              <?php echo wc_price( $_product->get_price() ); ?>
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
                <?php echo esc_html( $quantity ); ?>
              </span>
              <input type="hidden"
                     name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
                     class="quantity-input"
                     value="<?php echo esc_attr( $quantity ); ?>" />
              <button type="button" class="quantity-increment" style="background:none;border:none;cursor:pointer;">
                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/plus.png" alt="+" style="width:20px;">
              </button>
            </div>

            <!-- Remove -->
            <div style="flex:0 0 50px; text-align:center;">
              <?php $remove_url = wc_get_cart_remove_url( $cart_item_key ); ?>
              <a href="<?php echo esc_url( $remove_url ); ?>">
                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/trash-can-icon.png"
                     alt="Remove" style="width:20px;">
              </a>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- Actions Row -->
        <div style="display:flex; align-items:center; margin-bottom:2rem;">
          <input type="text"
                 name="coupon_code"
                 placeholder="Coupon Code..."
                 style="flex:1; padding:0.75rem; background:#222222; border:1px solid #333; color:#fff;" />

          <button type="submit"
                  name="apply_coupon"
                  class="button"
                  style="margin-left:1rem; background:#222222; color:#fff; padding:0.75rem 1.5rem; border:none;">
            Apply Coupon
          </button>

          <button type="submit"
                  name="update_cart"
                  value="Update cart"
                  class="button"
                  style="margin-left:1rem; background:#222222; color:#fff; padding:0.75rem 1.5rem; border:none;">
            Update Cart
          </button>

          <?php do_action( 'woocommerce_cart_actions' ); ?>
          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>"
             class="button"
             style="margin-left:1rem; background:#222222; color:#fff; padding:0.75rem 1.5rem; text-decoration:none;">
            Continue Shopping
          </a>
        </div>
      </form>

      <!-- Cart Totals -->
      <div style="margin-top:2rem; max-width:400px;">
        <h2 style="color:#fff; margin-bottom:1rem; text-align:left;">Cart Totals</h2>
        <div style="background:#222222; padding:1rem; text-align:left; color:#fff;">
          <p style="margin-bottom:0.5rem;">Cart Subtotal: <?php echo wc_price( WC()->cart->get_subtotal() ); ?></p>
          <p style="margin-bottom:0.5rem;">Shipping &amp; Handling:</p>
          <?php wc_cart_totals_shipping_html(); ?>
          <p style="color:#ccc; font-size:0.9rem; margin-top:1rem;">
            Shipping options will be updated during checkout.
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
               style="text-decoration:underline; color:#fff;">Change address</a>
          </p>
        </div>
        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
           class="button"
           style="display:block; margin-top:1rem; background:#ff0000; padding:1rem 2rem; text-transform:uppercase; text-decoration:none; text-align:center;">
          Checkout
        </a>
      </div>

    <?php else : ?>
      <p style="color:#fff; text-align:center;">Your cart is currently empty.</p>
    <?php endif; ?>
  </div>
  <!-- end .desktop-layout -->


  <!-- MOBILE LAYOUT (copied exactly from cartpage.php) -->
  <div class="mobile-layout">
    <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>

      <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
          $_product   = $cart_item['data'];
          $quantity   = $cart_item['quantity'];
          $size_display = '';
          if ( $cart_item['variation_id'] && ! empty( $cart_item['variation'] ) ) {
            foreach ( $cart_item['variation'] as $attr => $val ) {
              if ( stripos( $attr, 'size' ) !== false ) {
                $size_display = $val;
                break;
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
          ">
            <!-- Thumbnail -->
            <div style="flex: 0 0 50px;">
              <?php echo $_product->get_image( [80,80] ); ?>
            </div>

            <!-- Name & Size -->
            <div style="flex:1; margin-left:1rem; color:#fff;">
              <div style="font-weight:600;">
                <?php echo esc_html( $_product->get_name() ); ?>
              </div>
              <?php if ( $size_display ) : ?>
                <div style="color:#ccc; font-size:0.9rem;">
                  Size: <?php echo esc_html( $size_display ); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Quantity Controls - Mobile -->
          <div style="
            background: #333333;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 1rem;
            margin-top: -1rem;
            margin-bottom: 1rem;
          ">
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
                <?php echo esc_html( $quantity ); ?>
              </span>
              <input type="hidden"
                     name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
                     class="quantity-input"
                     value="<?php echo esc_attr( $quantity ); ?>" />
              <button type="button" class="quantity-increment" style="background:none;border:none;cursor:pointer;">
                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/plus.png" alt="+" style="width:20px;">
              </button>
            </div>

            <!-- Remove -->
            <div>
              <?php $remove_url = wc_get_cart_remove_url( $cart_item_key ); ?>
              <a href="<?php echo esc_url( $remove_url ); ?>">
                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/trash-can-icon.png"
                     alt="Remove" style="width:20px;">
              </a>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- Actions Row - Mobile -->
        <div style="margin-bottom:2rem;">
          <input type="text"
                 name="coupon_code"
                 placeholder="Coupon Code..."
                 style="width:100%; padding:0.75rem; background:#222222; border:1px solid #333; color:#fff; margin-bottom:1rem;" />

          <div style="display:flex; justify-content:space-between; gap:0.5rem;">
            <button type="submit"
                    name="apply_coupon"
                    class="button"
                    style="flex:1; background:#222222; color:#fff; padding:0.75rem 1rem; border:none;">
              Apply
            </button>

            <button type="submit"
                    name="update_cart"
                    value="Update cart"
                    class="button"
                    style="flex:1; background:#222222; color:#fff; padding:0.75rem 1rem; border:none;">
              Update
            </button>
          </div>

          <?php do_action( 'woocommerce_cart_actions' ); ?>
          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>"
             class="button"
             style="display:block; text-align:center; margin-top:1rem; background:#222222; color:#fff; padding:0.75rem 1rem; text-decoration:none;">
            Continue Shopping
          </a>
        </div>

        <!-- Cart Totals - Mobile -->
        <div>
          <h2 style="color:#fff; margin-bottom:1rem; text-align:center;">Cart Totals</h2>
          <div style="background:#222222; padding:1rem; text-align:left; color:#fff;">
            <p style="margin-bottom:0.5rem;">Cart Subtotal: <?php echo wc_price( WC()->cart->get_subtotal() ); ?></p>
            <p style="margin-bottom:0.5rem;">Shipping &amp; Handling:</p>
            <?php wc_cart_totals_shipping_html(); ?>
            <p style="color:#ccc; font-size:0.9rem; margin-top:1rem;">
              Shipping options will be updated during checkout.
              <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
                 style="text-decoration:underline; color:#fff;">Change address</a>
            </p>
          </div>
          <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
             class="button"
             style="display:block; margin-top:1rem; background:#ff0000; padding:1rem 2rem; text-transform:uppercase; text-decoration:none; text-align:center;">
            Checkout
          </a>
        </div>

      </form>

    <?php else : ?>
      <p style="color:#fff; text-align:center;">Your cart is currently empty.</p>
    <?php endif; ?>
  </div>
  <!-- end .mobile-layout -->

</main>

<!-- Cart Page JS (handles both desktop and mobile) -->
<script>
document.querySelectorAll('.quantity-decrement').forEach(btn => {
  btn.addEventListener('click', function(){
    // Works for both desktop and mobile layouts
    const wrapper = this.closest('.cart-item') || this.closest('div');
    const input   = wrapper.querySelector('.quantity-input') || wrapper.parentNode.querySelector('.quantity-input');
    const display = wrapper.querySelector('.quantity-display') || wrapper.parentNode.querySelector('.quantity-display');
    let val = parseInt(input.value, 10) || 1;
    if (val > 1) val--;
    input.value = val;
    display.textContent = val;
    // Enable update button when quantity changes
    const updateButtons = document.querySelectorAll('button[name="update_cart"]');
    updateButtons.forEach(button => button.removeAttribute('disabled'));
  });
});
document.querySelectorAll('.quantity-increment').forEach(btn => {
  btn.addEventListener('click', function(){
    // Works for both desktop and mobile layouts
    const wrapper = this.closest('.cart-item') || this.closest('div');
    const input   = wrapper.querySelector('.quantity-input') || wrapper.parentNode.querySelector('.quantity-input');
    const display = wrapper.querySelector('.quantity-display') || wrapper.parentNode.querySelector('.quantity-display');
    let val = parseInt(input.value, 10) || 0;
    val++;
    input.value = val;
    display.textContent = val;
    // Enable update button when quantity changes
    const updateButtons = document.querySelectorAll('button[name="update_cart"]');
    updateButtons.forEach(button => button.removeAttribute('disabled'));
  });
});

// Enable update cart buttons by default on page load
document.addEventListener('DOMContentLoaded', function() {
  const updateButtons = document.querySelectorAll('button[name="update_cart"]');
  updateButtons.forEach(button => button.removeAttribute('disabled'));
});
</script>

<!-- Mobile JS (exact from cartpage.php) -->
<script>
// The mobile JS is combined with the desktop JS to avoid duplicate handlers
// that would cause double increments/decrements
</script>

<?php
get_footer();
