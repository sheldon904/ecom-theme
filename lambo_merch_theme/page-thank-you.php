<?php
/**
 * Template Name: Thank You Page
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
                        <p class="thank-you-message">Thank you, we will get back to you soon.</p>
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
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    background-color: #000;
}

.thank-you-content {
    text-align: center;
    color: #fff;
    max-width: 600px;
    padding: 40px;
}

.success-icon {
    margin: 0 auto 40px;
    width: 64px;
    height: 64px;
}

.thank-you-title {
    font-size: 48px;
    margin-bottom: 30px;
    font-weight: 700;
    color: #fff !important;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.thank-you-message {
    font-size: 24px;
    margin-bottom: 40px;
    line-height: 1.6;
    color: #fff !important;
    font-weight: 400;
}

.back-to-home {
    margin-top: 40px;
}

.back-button {
    display: inline-block;
    background-color: #ff0000;
    color: #fff !important;
    font-weight: 600;
    padding: 15px 30px;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.back-button:hover {
    background-color: #cc0000;
    color: #fff !important;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,0,0,0.3);
}

@media (max-width: 768px) {
    .thank-you-title {
        font-size: 36px;
    }
    
    .thank-you-message {
        font-size: 20px;
    }
    
    .contact-thank-you-container {
        padding: 40px 15px;
    }
    
    .thank-you-content {
        padding: 30px 20px;
    }
}

@media (max-width: 480px) {
    .thank-you-title {
        font-size: 28px;
    }
    
    .thank-you-message {
        font-size: 18px;
    }
}
</style>

<?php get_footer(); ?>