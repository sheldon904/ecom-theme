<?php
/**
 * Template Name: Contact Page
 *
 * This template is used for displaying the Contact page.
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
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <h2>Get in Touch</h2>
                        <?php if (function_exists('get_field') && get_field('contact_info')) : ?>
                            <?php echo get_field('contact_info'); ?>
                        <?php else : ?>
                            <p>We'd love to hear from you. Fill out the form below or contact us directly using the information provided.</p>
                            <div class="contact-details">
                                <p><strong>Email:</strong> info@lambomerch.com</p>
                                <p><strong>Phone:</strong> +1 (800) LAMBO-MERCH</p>
                                <p><strong>Hours:</strong> Monday-Friday, 9am-5pm EST</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
                        <?php if (function_exists('get_field') && get_field('contact_form_shortcode')) : ?>
                            <?php echo do_shortcode(get_field('contact_form_shortcode')); ?>
                        <?php else : ?>
                            <!-- Default Contact Form -->
                            <form action="#" method="post" class="contact-form">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" id="subject" name="subject" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-red">Send Message</button>
                            </form>
                        <?php endif; ?>
                    </div>
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
                                <div class="col-md-8 offset-md-2">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Enter your email" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-red" type="submit"><i class="fa fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
