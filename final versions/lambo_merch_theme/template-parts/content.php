<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Lambo_Merch
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
	<div class="post-thumbnail">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail('lambo-featured', array('class' => 'img-fluid')); ?>
			</a>
		<?php endif; ?>
	</div>

	<div class="post-content">
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<span class="posted-on"><?php the_time('F j, Y'); ?></span>
					<span class="byline"> <?php esc_html_e('by', 'lambo-merch'); ?> <?php the_author_posts_link(); ?></span>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			if ( is_singular() ) :
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'lambo-merch' ),
							array(
								'span' => array(
									'class' => array(),
								),
							),
						),
						wp_kses_post( get_the_title() )
					)
				);
			else :
				// Display excerpt
				echo '<p>' . lambo_merch_excerpt(30) . '</p>';
			endif;
			?>
		</div><!-- .entry-content -->

		<?php if ( !is_singular() ) : ?>
		<footer class="entry-footer">
			<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'lambo-merch'); ?> <i class="fa fa-arrow-right"></i></a>
		</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div><!-- .post-content -->
</article><!-- #post-<?php the_ID(); ?> -->
