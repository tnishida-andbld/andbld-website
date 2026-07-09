<?php
/**
 * The template for displaying glossary tag archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andbld
 */

get_header();
?>

<div class="archive-conteiner glossary-container">
	<header class="title-header">
		<div class="row">
			<div class="title-wrap col-md-12">
				<div class="page-slug">glossary</div>
				<h1 class="entry-title"><?php
					$term = get_queried_object();
					if ($term) {
						echo esc_html($term->name);
					} else {
						echo 'AI×RPAの知識、ここに集約';
					}
				?></h1>
			</div>
		</div>
	</header><!-- .title-header -->

	<div class="container content-wrapper">
		<div class="row">
			<div class="content-area col-md-12">
				<main id="primary" class="site-main col-md-9">

					<?php if ( have_posts() ) : ?>

					<?php
						/* Start the Loop */
						while ( have_posts() ) :
						the_post();

						/*
						* Include the Post-Type-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Type name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', get_post_type() );

						endwhile;

						the_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>

				</main><!-- #main -->

				<div class="sidebar-area col-md-2">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer(); 