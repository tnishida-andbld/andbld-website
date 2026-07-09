<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andbld
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_singular() ) : ?>
	<div class="breadcrumb-wrapper">
		<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb( '<nav class="breadcrumb">','</nav>' );
			}
		?>
	</div>
	<?php endif; ?>


	<div class="post-thumbnail">
		<?php if (function_exists('andbld_default_post_thumbnail')) : ?>
			<img src="<?php echo esc_url(andbld_default_post_thumbnail()); ?>" alt="<?php the_title_attribute(); ?>" />
		<?php endif; ?>
	</div>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'blog' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<div class="post-categories">
					<?php
					$terms = get_the_terms(get_the_ID(), 'blog_category');
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						echo '<span class="cat-links">';
						foreach( $terms as $term ) {
							echo '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
						}
						echo '</span>';
					}
					?>
				</div>
				<div class="post-dates">
					<p class="posted-on">
						<span>投稿日：</span><?php echo esc_html(get_the_date('Y/m/d')); ?>
					</p>
					<span class="separator">|</span>
					<p class="modified-on">
						<span>最終更新日：</span><?php echo esc_html(get_the_modified_date('Y/m/d')); ?>
					</p>
				</div>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	
	<?php if ( is_singular() ) : ?>
	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'andbld' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'andbld' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php andbld_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
