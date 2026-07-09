<?php
/**
 * Template part for displaying glossary posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andbld
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('glossary-item'); ?>>

	<?php if ( is_singular() ) : ?>
	<div class="breadcrumb-wrapper">
		<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb( '<nav class="breadcrumb">','</nav>' );
			}
		?>
	</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
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
	<?php endif; ?>
	
	<?php if ( is_singular() ) : ?>
	<div class="glossary-meta">
		<div class="glossary-meta-item">
			<?php
			$categories = get_the_terms(get_the_ID(), 'glossary_category');
			if ($categories && !is_wp_error($categories)) :
			?>
			<div class="glossary-item-category">
				<span class="meta-label">カテゴリー:</span>
				<?php foreach ($categories as $category) : ?>
				<a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-tag"><?php echo $category->name; ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			
			<?php
			$tags = get_the_terms(get_the_ID(), 'glossary_tag');
			if ($tags && !is_wp_error($tags)) :
			?>
			<div class="glossary-item-tags">
				<span class="meta-label">タグ:</span>
				<?php foreach ($tags as $tag) : ?>
				<a href="<?php echo esc_url(get_term_link($tag)); ?>" class="category-tag tag-link"><?php echo $tag->name; ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

	<footer class="entry-footer">
		<?php if ( !is_singular() ) : ?>
			<a href="<?php the_permalink(); ?>" class="read-more">詳細を見る</a>
		<?php else : ?>
			<?php andbld_entry_footer(); ?>
		<?php endif; ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> --> 