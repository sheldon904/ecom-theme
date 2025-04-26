<?php
/**
 * Template Name: About Page Template
 *
 * This template is used for displaying the About page with mobile-specific adaptations.
 *
 * @package Lambo_Merch
 */

get_header();

// Include Mobile_Detect library if not already included
if (!class_exists('Mobile_Detect')) {
    require_once get_template_directory() . '/inc/mobile-detect.php';
}

$detect = new Mobile_Detect;
// Check if user is on a mobile device
$is_mobile = $detect->isMobile() && !$detect->isTablet();
?>

<main id="primary" class="site-main">
    <!-- Desktop layout - hidden on mobile -->
    <div class="desktop-layout" <?php if($is_mobile) echo 'style="display: none;"'; ?>>
        <div class="container">
            <!-- Shop Header -->
            <div class="row">
                <div class="col-md-8">
                    <h1 class="page-title">Where <span class="text-red">Passion</span> Meets <span class="text-red">Prestige</span></h1>
                    <div class="shop-description">
                        <p>Step into the fast lane of luxury with LAMBO MERCH, the premier destination for Lambo enthusiasts who live life in the boldest gear. From high-end apparel and precision-crafted accessories to exclusive collection inspired by the iconic brand, every item in out curated collection reflects the power, elegance and edge of the Lambo lifestyle.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png" alt="Lambo Merch Logo" class="img-fluid" height="70%" width="auto">
                </div>
            </div>

            <!-- Exclusive Drops Section -->
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2>Exclusive Drops</h2>
                    <p>Stay ahead of the pack. Our limited edition merchandise and rare releases are designed for true aficionados – and once they're gone, they're gone for good.</p>
                </div>
            </div>

            <!-- Members Only Section -->
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2>Members Only Access</h2>
                    <p>Be the first to know. Subscribe now to get early access to exclusive drops, insider updates, and VIP-only offers you won't find anywhere else.</p>
                    <p>Whether you're a long-time collector or just fueling your obsession, LAMBO MERCH is your ticket to the pinnacle of automotive-inspired luxury.</p>
                </div>
            </div>
        </div>

        <!-- Subscribe Section - Using fixed width and positioning -->
        <div style="text-align: center; padding: 40px 0;">
            <h2 style="font-size: 2rem; text-transform: uppercase; margin-bottom: 40px;">Subscribe for Discounts & Drops</h2>
            
            <!-- Fixed width container for the form - no bootstrap grid -->
            <div style="width: 670px; margin: 0 auto;">
                <form action="#" method="post">
                    <!-- First row -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <input type="text" name="first_name" placeholder="First Name" required style="width: 330px; background-color: #282828; border: none; color: #fff; padding: 10px 15px;">
                        <input type="email" name="email" placeholder="Email" required style="width: 330px; background-color: #282828; border: none; color: #fff; padding: 10px 15px;">
                    </div>
                    
                    <!-- Second row -->
                    <div style="display: flex; justify-content: space-between;">
                        <input type="text" name="last_name" placeholder="Last Name" required style="width: 330px; background-color: #282828; border: none; color: #fff; padding: 10px 15px;">
                        <div style="width: 330px; text-align: center;">
                            <button type="submit" style="width: 330px; height: 40px; background-color: #ff0000; border: none; color: #fff; font-weight: bold;">SEND IT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Motto Section -->
        <div class="container">
            <div class="row" style="margin-top: 40px;">
                <div class="col-md-12 text-center">
                    <div class="motto">
                        <p class="motto-text text-red">Live Loud.</p>
                        <p class="motto-text text-red">Drive Proud.</p>
                        <p class="motto-text text-red">Dress Like It.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile layout - hidden on desktop -->
    <div class="mobile-layout" <?php if(!$is_mobile) echo 'style="display: none;"'; ?>>
        <div class="container">
            <!-- Shop Header - Centered on mobile -->
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="page-title mobile-title">Where <span class="text-red">Passion</span> Meets <span class="text-red">Prestige</span></h1>
                    <div class="shop-description">
                        <p>Step into the fast lane of luxury with LAMBO MERCH, the premier destination for Lambo enthusiasts who live life in the boldest gear. From high-end apparel and precision-crafted accessories to exclusive collection inspired by the iconic brand, every item in out curated collection reflects the power, elegance and edge of the Lambo lifestyle.</p>
                    </div>
                </div>
            </div>

            <!-- Exclusive Drops Section -->
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Exclusive Drops</h2>
                    <p>Stay ahead of the pack. Our limited edition merchandise and rare releases are designed for true aficionados – and once they're gone, they're gone for good.</p>
                </div>
            </div>

            <!-- Members Only Section -->
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Members Only Access</h2>
                    <p>Be the first to know. Subscribe now to get early access to exclusive drops, insider updates, and VIP-only offers you won't find anywhere else.</p>
                    <p>Whether you're a long-time collector or just fueling your obsession, LAMBO MERCH is your ticket to the pinnacle of automotive-inspired luxury.</p>
                </div>
            </div>
        </div>

        <!-- Subscribe Section for Mobile - Vertical stacking -->
        <div style="text-align: center; padding: 40px 0;">
            <h2 style="font-size: 2rem; text-transform: uppercase; margin-bottom: 40px;">Subscribe for Discounts & Drops</h2>
            
            <!-- Mobile form container -->
            <div style="width: 90%; margin: 0 auto;">
                <form action="#" method="post">
                    <!-- Vertically stacked inputs -->
                    <div style="margin-bottom: 10px;">
                        <input type="text" name="first_name" placeholder="First Name" required style="width: 100%; background-color: #282828; border: none; color: #fff; padding: 10px 15px;">
                    </div>
                    
                    <div style="margin-bottom: 10px;">
                        <input type="email" name="email" placeholder="Email" required style="width: 100%; background-color: #282828; border: none; color: #fff; padding: 10px 15px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <input type="text" name="last_name" placeholder="Last Name" required style="width: 100%; background-color: #282828; border: none; color: #fff; padding: 10px 15px;">
                    </div>
                    
                    <div style="width: 100%;">
                        <button type="submit" style="width: 100%; height: 40px; background-color: #ff0000; border: none; color: #fff; font-weight: bold;">SEND IT</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Motto Section -->
        <div class="container">
            <div class="row" style="margin-top: 40px;">
                <div class="col-12 text-center">
                    <div class="motto">
                        <p class="motto-text text-red">Live Loud.</p>
                        <p class="motto-text text-red">Drive Proud.</p>
                        <p class="motto-text text-red">Dress Like It.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Mobile-specific styles */
@media (max-width: 767px) {
    .desktop-layout {
        display: none !important;
    }
    
    .mobile-layout {
        display: block !important;
    }
    
    /* Center the title on mobile */
    .mobile-title {
        text-align: center;
        margin-bottom: 20px;
    }
    
    /* Center text content */
    .shop-description {
        text-align: center;
    }
    
    /* Form input spacing */
    .mobile-layout input {
        margin-bottom: 10px;
    }
    
    /* Make the send button full width */
    .mobile-layout button {
        width: 100%;
    }
}

/* Ensure proper display based on device type regardless of viewport resizing */
@media (min-width: 768px) {
    .desktop-layout {
        display: block !important;
    }
    
    .mobile-layout {
        display: none !important;
    }
}
</style>

<?php
get_footer();