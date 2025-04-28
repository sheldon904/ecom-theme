<?php
/**
 * Thankyou page - Order received
 *
 * This template overrides the default WooCommerce thankyou.php
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order lambo-order-received">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<div class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed alert alert-danger">
				<p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
			</div>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="order-confirmation-header">
				<div class="success-icon">
					<svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="12" cy="12" r="11" stroke="#4CAF50" stroke-width="2"/>
						<path d="M7 12L10 15L17 8" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<h2 class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
					<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?>
				</h2>
			</div>
            
            <!-- Order Items Summary (Simple) at the top -->
            <div class="order-items-summary">
                <h3><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h3>
                <div class="items-grid">
                    <?php
                    foreach ( $order->get_items() as $item_id => $item ) {
                        $product = $item->get_product();
                        $is_visible = $product && $product->is_visible();
                        
                        // Get product image
                        $thumbnail = $product ? $product->get_image( array( 64, 64 ) ) : '';
                        ?>
                        <div class="order-item-card">
                            <?php if ( $thumbnail ) : ?>
                                <div class="item-thumbnail">
                                    <?php echo $thumbnail; ?>
                                </div>
                            <?php endif; ?>
                            <div class="item-details">
                                <div class="item-name">
                                    <?php echo wp_kses_post( $item->get_name() ); ?>
                                </div>
                                <div class="item-meta">
                                    <span class="item-quantity">
                                        <?php echo esc_html_e( 'Qty: ', 'woocommerce' ); ?><?php echo wp_kses_post( $item->get_quantity() ); ?>
                                    </span>
                                    <span class="item-price">
                                        <?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                
                <!-- Order Totals -->
                <div class="order-totals">
                    <?php
                    foreach ( $order->get_order_item_totals() as $key => $total ) {
                        // Skip the subtotal if this is just a single item order
                        if ($key === 'cart_subtotal' && count($order->get_items()) <= 1) {
                            continue;
                        }
                        ?>
                        <div class="totals-row <?php echo $key === 'order_total' ? 'grand-total' : ''; ?>">
                            <span class="totals-label"><?php echo esc_html( $total['label'] ); ?></span>
                            <span class="totals-value"><?php echo wp_kses_post( $total['value'] ); ?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>

			<div class="order-overview-container">
				<div class="row">
					<div class="col-md-12">
						<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

							<li class="woocommerce-order-overview__order order">
								<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
								<strong><?php echo $order->get_order_number(); ?></strong>
							</li>

							<li class="woocommerce-order-overview__date date">
								<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
								<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
							</li>

							<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
								<li class="woocommerce-order-overview__email email">
									<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
									<strong><?php echo $order->get_billing_email(); ?></strong>
								</li>
							<?php endif; ?>

							<li class="woocommerce-order-overview__total total">
								<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
								<strong><?php echo $order->get_formatted_order_total(); ?></strong>
							</li>

							<?php if ( $order->get_payment_method_title() ) : ?>
								<li class="woocommerce-order-overview__payment-method method">
									<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
									<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
								</li>
							<?php endif; ?>

						</ul>
					</div>
				</div>
			</div>

		<?php endif; ?>

		<div class="order-details-container">
			<div class="row">
				<div class="col-md-12">
					<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
				</div>
			</div>
		</div>

		<!-- Customer Details Section (full width) -->
		<div class="customer-details-section">
			<div class="row">
				<div class="col-sm-12">
					<div class="customer-details-box">
						<h3><?php esc_html_e( 'Customer Details', 'woocommerce' ); ?></h3>
						<div class="customer-details-content">
							<div class="row">
								<!-- Billing Address -->
								<div class="col-sm-12 col-md-6">
									<div class="address-section">
										<h4><?php esc_html_e( 'Billing Address', 'woocommerce' ); ?></h4>
										<address>
											<?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>

											<?php if ( $order->get_billing_phone() ) : ?>
												<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
											<?php endif; ?>

											<?php if ( $order->get_billing_email() ) : ?>
												<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
											<?php endif; ?>
										</address>
									</div>
								</div>

								<!-- Shipping Address if different -->
								<div class="col-sm-12 col-md-6">
									<?php if ( $order->get_shipping_address_1() && $order->get_shipping_address_1() !== $order->get_billing_address_1() ) : ?>
										<div class="address-section">
											<h4><?php esc_html_e( 'Shipping Address', 'woocommerce' ); ?></h4>
											<address>
												<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>
											</address>
										</div>
									<?php else: ?>
										<div class="address-section">
											<h4><?php esc_html_e( 'Shipping Address', 'woocommerce' ); ?></h4>
											<address>
												<?php echo esc_html__( 'Same as billing address', 'woocommerce' ); ?>
											</address>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Continue Shopping Button -->
		<div class="continue-shopping-container text-center mt-5">
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="button continue-shopping"><?php esc_html_e( 'Continue Shopping', 'woocommerce' ); ?></a>
		</div>

	<?php else : ?>

		<div class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
			<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?>
		</div>

	<?php endif; ?>

</div>

<style>
/* Order Received Page Custom Styling */
.lambo-order-received {
	max-width: 1140px;
	margin: 0 auto;
	padding: 20px;
	font-family: "Source Sans Pro", sans-serif;
	color: #fff;
}

.order-confirmation-header {
	text-align: center;
	margin-bottom: 40px;
	padding: 30px 0;
}

.success-icon {
	margin: 0 auto 20px;
	width: 64px;
	height: 64px;
}

.woocommerce-thankyou-order-received {
	font-size: 28px;
	margin-bottom: 30px;
	color: #fff;
	font-weight: 600;
}

.order-overview-container {
	margin-bottom: 40px;
	background: #1a1a1a;
	padding: 20px;
	border-radius: 5px;
}

.woocommerce-order-overview {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
	list-style: none;
	padding: 0;
	margin: 0;
}

.woocommerce-order-overview li {
	flex: 1 1 200px;
	margin-bottom: 15px;
	padding: 10px;
	border-right: 1px solid #333;
}

.woocommerce-order-overview li:last-child {
	border-right: none;
}

.woocommerce-order-overview li strong {
	display: block;
	margin-top: 5px;
	font-size: 16px;
	color: #ddd;
}

.order-details-box,
.customer-details-box {
	background: #1a1a1a;
	padding: 25px;
	margin-bottom: 30px;
	border-radius: 5px;
	height: 100%;
}

.order-details-sections h3,
.order-items-container h3 {
	font-size: 22px;
	margin-bottom: 20px;
	border-bottom: 1px solid #333;
	padding-bottom: 10px;
	color: #fff;
}

.address-section {
	margin-bottom: 20px;
}

.address-section h4 {
	font-size: 18px;
	margin-bottom: 15px;
	color: #ddd;
}

.address-section address {
	line-height: 1.7;
	color: #bbb;
}

.woocommerce-table--order-details {
	width: 100%;
	background: #1a1a1a;
	border-radius: 5px;
	padding: 10px 0;
	margin-bottom: 30px;
}

.woocommerce-table--order-details th,
.woocommerce-table--order-details td {
	padding: 15px;
	text-align: left;
	vertical-align: middle;
	border-bottom: 1px solid #333;
}

.woocommerce-table--order-details thead th {
	font-weight: 600;
	color: #fff;
	border-bottom: 2px solid #333;
}

.product-info {
	display: flex;
	align-items: center;
}

.product-thumbnail {
	margin-right: 15px;
	width: 64px;
}

.product-thumbnail img {
	width: 100%;
	height: auto;
	border-radius: 3px;
}

.product-details a {
	color: #fff;
	text-decoration: none;
	font-weight: 600;
}

.product-details a:hover {
	color: #999;
}

.woocommerce-table--order-details tfoot th {
	text-align: right;
	font-weight: 600;
}

.woocommerce-table--order-details tfoot tr:last-child th,
.woocommerce-table--order-details tfoot tr:last-child td {
	border-bottom: none;
	font-weight: 700;
	font-size: 18px;
}

.continue-shopping-container {
	margin-top: 40px;
}

.button.continue-shopping {
	display: inline-block;
	background-color: #222;
	color: #fff;
	font-weight: 600;
	padding: 12px 25px;
	text-decoration: none;
	border-radius: 3px;
	border: 1px solid #444;
	transition: all 0.3s ease;
}

.button.continue-shopping:hover {
	background-color: #333;
	border-color: #555;
}

@media (max-width: 768px) {
	.woocommerce-order-overview {
		display: block;
	}
	
	.woocommerce-order-overview li {
		border-right: none;
		border-bottom: 1px solid #333;
		padding: 10px 0;
	}
	
	.woocommerce-order-overview li:last-child {
		border-bottom: none;
	}
	
	.woocommerce-table--order-details th,
	.woocommerce-table--order-details td {
		padding: 10px;
	}
}
</style>