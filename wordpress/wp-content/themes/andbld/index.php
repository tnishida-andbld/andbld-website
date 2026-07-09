<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andbld
 */

get_header();
?>

<div class="archive-conteiner news-container">
	<header class="title-header">
		<div class="row">
			<div class="title-wrap col-md-12">
				<div class="page-slug"><?php
					if (is_category()) {
						echo esc_html(get_queried_object()->slug);
					} else {
						echo 'news';
					}
				?></div>
				<h1 class="entry-title"><?php
					if (is_category()) {
						echo esc_html(single_cat_title('', false));
					} else {
						echo 'お知らせ';
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
get_sidebar();
get_footer();
