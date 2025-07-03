<?php
/**
 * Template Name: Contact Thank You
 * 
 * This template displays a thank you message after contact form submission.
 * 
 * @package Lambo_Merch
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-thank-you-container">
                    <div class="thank-you-content">
                        <div class="success-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11" stroke="#ff0000" stroke-width="2"/>
                                <path d="M7 12L10 15L17 8" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h1 class="thank-you-title">Thank You!</h1>
                        <p class="thank-you-message">Thank you for your message! We'll get back to you soon.</p>
                        <div class="back-to-home">
                            <a href="<?php echo home_url(); ?>" class="back-button">Return to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.contact-thank-you-container {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

.thank-you-content {
    text-align: center;
    color: #fff;
    max-width: 500px;
}

.success-icon {
    margin: 0 auto 30px;
    width: 64px;
    height: 64px;
}

.thank-you-title {
    font-size: 36px;
    margin-bottom: 20px;
    font-weight: 700;
    color: #fff;
}

.thank-you-message {
    font-size: 18px;
    margin-bottom: 30px;
    line-height: 1.6;
    color: #ddd;
}

.back-to-home {
    margin-top: 30px;
}

.back-button {
    display: inline-block;
    background-color: #ff0000;
    color: #fff;
    font-weight: 600;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.back-button:hover {
    background-color: #cc0000;
    color: #fff;
    text-decoration: none;
}

@media (max-width: 768px) {
    .thank-you-title {
        font-size: 28px;
    }
    
    .thank-you-message {
        font-size: 16px;
    }
}
</style>

<?php get_footer(); ?>