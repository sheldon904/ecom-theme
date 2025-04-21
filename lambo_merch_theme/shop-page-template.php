<?php
/**
 * Template Name: Shop Page Template
 *
 * This is a custom template for the shop page.
 *
 * @package Lambo_Merch
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">Shop the <span class="text-red">Luxe</span> Lane</h1>
                <div class="shop-description">
                    <p>Welcome to the LAMBO MERCH - your destination for premium gear built for speed, style, and status. Explore our handpicked collection of high-end apparel, accessories, and collectibles crafted for true Lambo enthusiasts.</p>
                    <p>New drops hit fast, the best pieces go faster. <span class="text-red">Subscribe now</span> to unlock early access and never miss an exclusive release.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/images/logo/Big_LM_logo.png" alt="Lambo Merch Logo" class="img-fluid">
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-9">
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-md-6 mb-4">
                        <div class="product-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/products/bull_1.png" alt="Bull T-Shirt 1" class="img-fluid">
                            <h3>Bull T-Shirt 1</h3>
                            <span class="price">$35</span>
                            <a href="#" class="btn btn-red add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-6 mb-4">
                        <div class="product-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/products/bull_2.png" alt="Bull T-Shirt 2" class="img-fluid">
                            <h3>Bull T-Shirt 2</h3>
                            <span class="price">$40</span>
                            <a href="#" class="btn btn-red add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="col-md-6 mb-4">
                        <div class="product-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/products/bull_3.png" alt="Bull T-Shirt 3" class="img-fluid">
                            <h3>Bull T-Shirt 3</h3>
                            <span class="price">$50</span>
                            <a href="#" class="btn btn-red add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                    
                    <!-- Product 4 -->
                    <div class="col-md-6 mb-4">
                        <div class="product-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/products/bull_4.png" alt="Bull T-Shirt 4" class="img-fluid">
                            <h3>Bull T-Shirt 4</h3>
                            <span class="price">$45</span>
                            <a href="#" class="btn btn-red add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="row">
                    <div class="col-12">
                        <div class="product-pagination">
                            <a href="#" class="pagination-arrow pagination-prev"><i class="fa fa-arrow-left"></i></a>
                            <span class="pagination-page">Page 1 of 1</span>
                            <a href="#" class="pagination-arrow pagination-next"><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="shop-filters">
                    <h3>Filter by</h3>
                    <ul class="filter-list">
                        <li class="active"><a href="#" class="text-red">Default</a></li>
                        <li><a href="#" class="text-red">Price</a></li>
                        <li><a href="#" class="text-red">Category</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();