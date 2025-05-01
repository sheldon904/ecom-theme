<?php
/**
 * Template Name: Search Debug Template
 * Description: A template for debugging search functionality with FiboSearch
 */

get_header();
?>

<div class="container search-debug-container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="search-debug-title">Search Debug Results</h1>
            
            <div class="search-debug-info">
                <h2>Search Information</h2>
                <div class="debug-section">
                    <h3>Request Parameters:</h3>
                    <pre><?php print_r($_GET); ?></pre>
                    
                    <h3>Search Query:</h3>
                    <p>Search term: <?php echo isset($_GET['s']) ? esc_html($_GET['s']) : 'None'; ?></p>
                    <p>Post type: <?php echo isset($_GET['post_type']) ? esc_html($_GET['post_type']) : 'Any'; ?></p>
                    <p>FiboSearch: <?php echo isset($_GET['dgwt_wcas']) ? 'Yes' : 'No'; ?></p>
                </div>
            </div>
            
            <?php if (have_posts()) : ?>
                <div class="search-debug-results">
                    <h2>Search Results (<?php echo $wp_query->found_posts; ?> items found)</h2>
                    
                    <div class="products columns-3">
                        <?php while (have_posts()) : the_post(); ?>
                            <?php 
                            if ('product' === get_post_type()) {
                                wc_get_template_part('content', 'product');
                            } else {
                                ?>
                                <div class="non-product-result">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="excerpt"><?php the_excerpt(); ?></div>
                                </div>
                                <?php
                            }
                            ?>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <div class="no-results">
                    <h2>No results found</h2>
                    <p>Your search for <strong>"<?php echo get_search_query(); ?>"</strong> returned no results.</p>
                    
                    <div class="search-form-container">
                        <h3>Try a different search:</h3>
                        <?php echo do_shortcode('[fibosearch]'); ?>
                    </div>
                    
                    <p>Or browse our product categories:</p>
                    <?php 
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                    ));
                    
                    if (!empty($product_categories) && !is_wp_error($product_categories)) {
                        echo '<ul class="product-categories">';
                        foreach ($product_categories as $category) {
                            echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.search-debug-container {
    padding: 40px 0;
}

.search-debug-title {
    margin-bottom: 30px;
    text-align: center;
    color: #fff;
    text-transform: uppercase;
    font-size: 32px;
}

.search-debug-info {
    margin-bottom: 40px;
    background-color: #222;
    padding: 20px;
    border: 1px solid #333;
}

.debug-section {
    margin-bottom: 20px;
}

.debug-section h3 {
    margin-top: 15px;
    margin-bottom: 10px;
    color: #FF0000;
}

.debug-section pre {
    background-color: #333;
    padding: 10px;
    color: #fff;
    overflow: auto;
    font-family: monospace;
    font-size: 14px;
}

.search-debug-results {
    margin-bottom: 40px;
}

.no-results {
    text-align: center;
    padding: 50px 0;
}

.no-results h2 {
    color: #FF0000;
    margin-bottom: 20px;
}

.product-categories {
    list-style: none;
    padding: 0;
    margin: 20px 0;
    text-align: center;
}

.product-categories li {
    display: inline-block;
    margin: 0 10px 10px 0;
}

.product-categories li a {
    display: block;
    padding: 8px 15px;
    background-color: #333;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
}

.product-categories li a:hover {
    background-color: #FF0000;
}

.search-form-container {
    max-width: 600px;
    margin: 30px auto;
}
</style>

<?php get_footer(); ?>