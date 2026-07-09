<?php
/**
 * The template for displaying single glossary posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andbld
 */

get_header();
?>

<div class="single-conteiner glossary-container">
	<div class="container content-wrapper">
		<div class="row">
			<div class="content-area col-md-12">
				<main id="primary" class="site-main col-md-9">

					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content-glossary', get_post_type() );

						the_post_navigation(
							array(
								'prev_text' => '<span class="nav-subtitle">' . esc_html__( '前の用語:', 'andbld' ) . '</span> <span class="nav-title">%title</span>',
								'next_text' => '<span class="nav-subtitle">' . esc_html__( '次の用語:', 'andbld' ) . '</span> <span class="nav-title">%title</span>',
							)
						);

					endwhile; // End of the loop.
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