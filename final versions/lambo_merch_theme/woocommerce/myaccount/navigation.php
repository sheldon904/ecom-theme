<?php
/**
 * My Account navigation
 *
 * Custom navigation template for Lambo Merch.
 *
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;

// Customize the menu items if needed
$menu_items = wc_get_account_menu_items();

// Remove downloads from menu
if (isset($menu_items['downloads'])) {
    unset($menu_items['downloads']);
}

// You can modify the menu items here if needed
// For example, to rename or reorder items
// $menu_items['dashboard'] = 'My Dashboard';
?>

<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <?php foreach ( $menu_items as $endpoint => $label ) : ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>