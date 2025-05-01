<?php
/**
 * Template Name: FiboSearch Page
 * A simple template for displaying FiboSearch
 *
 * @package Lambo_Merch
 */

get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="search-container">
                <h1 class="search-title"><?php esc_html_e('Search Products', 'lambo-merch'); ?></h1>
                
                <div class="search-form-container">
                    <?php echo do_shortcode('[fibosearch]'); ?>
                </div>
                
                <div class="search-back-link">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="back-to-home">
                        <?php esc_html_e('Back to Home', 'lambo-merch'); ?>
                    </a>
                </div>
                
                <div class="browse-products">
                    <h3><?php esc_html_e('Browse All Products:', 'lambo-merch'); ?></h3>
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button browse-button">
                        <?php esc_html_e('Shop Now', 'lambo-merch'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple FiboSearch styles */
.search-container {
    padding: 60px 0;
    text-align: center;
}

.search-title {
    margin-bottom: 30px;
    text-align: center;
    color: #fff;
    text-transform: uppercase;
    font-size: 32px;
}

.search-form-container {
    max-width: 800px;
    margin: 0 auto 40px;
}

.search-back-link {
    margin: 30px 0;
}

.back-to-home {
    display: inline-block;
    padding: 8px 16px;
    background-color: #333;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-to-home:hover {
    background-color: #444;
    color: #fff;
}

.browse-products {
    margin-top: 40px;
}

.browse-products h3 {
    margin-bottom: 15px;
    color: #fff;
}

.browse-button {
    display: inline-block;
    padding: 12px 24px;
    background-color: #FF0000;
    color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: bold;
    transition: all 0.3s ease;
}

.browse-button:hover {
    background-color: #cc0000;
    color: #fff;
}

/* FiboSearch styling overrides */
.dgwt-wcas-search-wrapp {
    max-width: 100% !important;
}

.dgwt-wcas-search-form {
    margin: 0 !important;
}

.dgwt-wcas-sf-wrapp input[type=search].dgwt-wcas-search-input {
    background-color: #222 !important;
    border: 1px solid #444 !important;
    color: #fff !important;
    height: 50px !important;
    padding: 10px 15px !important;
    font-size: 16px !important;
}

.dgwt-wcas-sf-wrapp input[type=search].dgwt-wcas-search-input:focus {
    box-shadow: none !important;
    border-color: #FF0000 !important;
}

.dgwt-wcas-search-submit {
    background-color: #FF0000 !important;
    color: #fff !important;
    height: 50px !important;
    transition: all 0.3s ease !important;
}

.dgwt-wcas-search-submit:hover {
    background-color: #cc0000 !important;
}
</style>

<?php get_footer(); ?>