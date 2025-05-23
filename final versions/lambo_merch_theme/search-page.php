<?php
/**
 * Template Name: Search Page
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
                    <form role="search" method="get" class="woocommerce-product-search custom-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-wrap">
                            <input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php echo esc_attr_x('Search products...', 'placeholder', 'lambo-merch'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <input type="hidden" name="post_type" value="product" />
                        </div>
                        <button type="submit" class="search-submit">
                            <?php esc_html_e('Search', 'lambo-merch'); ?>
                        </button>
                    </form>
                </div>
                
                <?php
                // Check if there is a search query
                if (get_search_query()) {
                    // Create a custom query to display search results
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $search_query = array(
                        'post_type'      => 'product',
                        's'              => get_search_query(),
                        'posts_per_page' => 12,
                        'paged'          => $paged,
                    );
                    
                    $search_results = new WP_Query($search_query);
                    
                    if ($search_results->have_posts()) {
                        echo '<div class="search-results-count">';
                        printf(
                            esc_html(_n('Found %d result for your search', 'Found %d results for your search', $search_results->found_posts, 'lambo-merch')),
                            $search_results->found_posts
                        );
                        echo '</div>';
                        
                        echo '<div class="search-results products columns-3">';
                        
                        while ($search_results->have_posts()) {
                            $search_results->the_post();
                            global $product;
                            
                            // Display the product using WooCommerce template parts
                            wc_get_template_part('content', 'product');
                        }
                        
                        echo '</div>';
                        
                        // Pagination
                        echo '<div class="pagination">';
                        echo paginate_links(array(
                            'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'total'        => $search_results->max_num_pages,
                            'current'      => max(1, get_query_var('paged')),
                            'format'       => '?paged=%#%',
                            'show_all'     => false,
                            'type'         => 'list',
                            'end_size'     => 2,
                            'mid_size'     => 1,
                            'prev_next'    => true,
                            'prev_text'    => sprintf('<i></i> %1$s', __('Previous', 'lambo-merch')),
                            'next_text'    => sprintf('%1$s <i></i>', __('Next', 'lambo-merch')),
                            'add_args'     => false,
                            'add_fragment' => '',
                        ));
                        echo '</div>';
                        
                        wp_reset_postdata();
                    } else {
                        echo '<div class="no-results">';
                        echo '<p>' . esc_html__('No products found matching your search criteria.', 'lambo-merch') . '</p>';
                        echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="button continue-shopping">' . esc_html__('Browse Products', 'lambo-merch') . '</a>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    .search-container {
        padding: 40px 0;
    }
    
    .search-title {
        margin-bottom: 30px;
        text-align: center;
        color: #fff;
    }
    
    .search-form-container {
        max-width: 800px;
        margin: 0 auto 40px;
    }
    
    .custom-search-form {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .search-input-wrap {
        flex: 1;
        margin-right: 15px;
    }
    
    .search-field {
        width: 100%;
        padding: 12px 15px;
        background-color: #222;
        border: 1px solid #444;
        color: #fff;
        font-size: 16px;
        border-radius: 0;
    }
    
    .search-submit {
        background-color: #C8B100; /* Gold color */
        color: #000;
        padding: 12px 30px;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        border-radius: 0;
    }
    
    .search-results-count {
        margin-bottom: 20px;
        text-align: center;
        font-size: 18px;
        color: #fff;
    }
    
    .search-results {
        margin-bottom: 40px;
    }
    
    .no-results {
        text-align: center;
        padding: 50px 0;
    }
    
    .no-results p {
        font-size: 18px;
        margin-bottom: 20px;
        color: #fff;
    }
    
    .continue-shopping {
        background-color: #C8B100; /* Gold color */
        color: #000;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
    }
    
    .pagination {
        text-align: center;
    }
    
    .pagination ul {
        display: inline-block;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .pagination ul li {
        display: inline-block;
        margin: 0 5px;
    }
    
    .pagination ul li a,
    .pagination ul li span {
        display: inline-block;
        padding: 8px 12px;
        background-color: #222;
        color: #fff;
        text-decoration: none;
    }
    
    .pagination ul li span.current {
        background-color: #C8B100;
        color: #000;
    }
    
    @media (max-width: 767px) {
        .custom-search-form {
            flex-direction: column;
        }
        
        .search-input-wrap {
            width: 100%;
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .search-submit {
            width: 100%;
        }
    }
</style>

<?php get_footer(); ?>