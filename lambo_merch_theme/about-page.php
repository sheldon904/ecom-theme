<?php
/**
 * Template Name: About Page
 *
 * This template is used for displaying the About page.
 *
 * @package Lambo_Merch
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Page Banner -->
    <section class="page-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-title">Where <span class="text-red">Passion</span> Meets <span class="text-red">Prestige</span></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="about-image">
                            <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                        </div>
                    <?php else : ?>
                        <div class="about-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-default.jpg" alt="<?php the_title_attribute(); ?>" class="img-fluid">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <div class="about-text">
                        <?php if (function_exists('get_field') && get_field('about_intro')) : ?>
                            <?php echo get_field('about_intro'); ?>
                        <?php else : ?>
                            <p>Step into the fast lane of luxury with LAMBO MERCH, the premier destination for Lambo enthusiasts who live life in the boldest gear. From high-end apparel and precision-crafted accessories to exclusive collectibles inspired by the iconic brand, every item in our curated collection reflects the power, elegance, and edge of the Lambo lifestyle.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Exclusive Drops Section -->
    <section class="exclusive-drops">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="section-title">Exclusive Drops</h2>
                    <?php if (function_exists('get_field') && get_field('exclusive_drops_text')) : ?>
                        <div class="section-content">
                            <?php echo get_field('exclusive_drops_text'); ?>
                        </div>
                    <?php else : ?>
                        <div class="section-content">
                            <p>Stay ahead of the pack. Our limited-edition merchandise and rare releases are designed for true aficionados — and once they're gone, they're gone for good.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Members Only Section -->
    <section class="members-only">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="section-title">Members Only Access</h2>
                    <?php if (function_exists('get_field') && get_field('members_only_text')) : ?>
                        <div class="section-content">
                            <?php echo get_field('members_only_text'); ?>
                        </div>
                    <?php else : ?>
                        <div class="section-content">
                            <p>Be the first to know. Subscribe now to get early access to exclusive drops, insider updates, and VIP-only offers you won't find anywhere else.</p>
                            <p>Whether you're a long-time collector or just fueling your obsession, LAMBO MERCH is your ticket to the pinnacle of automotive-inspired luxury.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Subscribe Section -->
    <section class="subscribe-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="section-title">Subscribe for Discounts & Drops</h2>
                    <div class="subscription-form">
                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" placeholder="First Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" placeholder="Last Name" required>
                                </div>
                                <div class="col-md-6 text-left">
                                    <div class="g-recaptcha-placeholder">
                                        <!-- This is where the reCAPTCHA would go -->
                                        <div class="recaptcha-box">
                                            <span>I'm not a robot</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-red">SEND IT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Motto Section -->
    <section class="motto-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="motto">
                        <p class="motto-text text-red">Live Loud.</p>
                        <p class="motto-text text-red">Drive Proud.</p>
                        <p class="motto-text text-red">Dress Like It.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();