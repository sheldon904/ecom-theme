<?php
/**
 * Template Name: FiboSearch Results
 * Description: Template for handling FiboSearch results
 *
 * @package Lambo_Merch
 */

get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="search-container">
                <h1 class="search-title"><?php esc_html_e('Search Results', 'lambo-merch'); ?></h1>
                
                <div class="search-form-container">
                    <?php echo do_shortcode('[fibosearch]'); ?>
                </div>
                
                <?php
                // Check if there is a search query
                if (get_search_query()) {
                    // Get current post type from URL or default to product
                    $post_type = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : 'product';
                    
                    // Create a custom query to display search results
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $search_query = array(
                        'post_type'      => $post_type,
                        's'              => get_search_query(),
                        'posts_per_page' => 12,
                        'paged'          => $paged,
                    );
                    
                    // Add product visibility tax query for WooCommerce products
                    if ($post_type === 'product') {
                        $search_query['tax_query'] = array(
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'exclude-from-search',
                                'operator' => 'NOT IN',
                            ),
                        );
                    }
                    
                    $search_results = new WP_Query($search_query);
                    
                    if ($search_results->have_posts()) {
                        echo '<div class="search-results-count">';
                        printf(
                            esc_html(_n('Found %d result for your search', 'Found %d results for your search', $search_results->found_posts, 'lambo-merch')),
                            $search_results->found_posts
                        );
                        echo '</div>';
                        
                        if ($post_type === 'product') {
                            echo '<div class="search-results products columns-3">';
                            
                            while ($search_results->have_posts()) {
                                $search_results->the_post();
                                global $product;
                                
                                // Display the product using WooCommerce template parts
                                wc_get_template_part('content', 'product');
                            }
                            
                            echo '</div>';
                        } else {
                            // For non-product post types
                            echo '<div class="search-results regular-posts">';
                            
                            while ($search_results->have_posts()) {
                                $search_results->the_post();
                                ?>
                                <div class="search-item">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="search-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                                </div>
                                <?php
                            }
                            
                            echo '</div>';
                        }
                        
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
                        echo '<p>' . esc_html__('No results found matching your search criteria.', 'lambo-merch') . '</p>';
                        echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="button continue-shopping">' . esc_html__('Browse Products', 'lambo-merch') . '</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="no-search-query">';
                    echo '<p>' . esc_html__('Please enter a search term to find products.', 'lambo-merch') . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>