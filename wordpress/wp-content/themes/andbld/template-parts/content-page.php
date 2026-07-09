<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andbld
 */

 $page = get_post( get_the_ID() );
 $slug = $page->post_name;

?>
 
<div class="page-conteiner <?php echo esc_html($slug); ?>-container">
	<header class="entry-header">
		<div class="row">
			<div class="title-wrap col-md-12">
				<?php if( is_page('bizscan')): ?>
					<div class="page-slug service-slug">BizScan</div>
				<?php elseif( is_page('creativeforce')): ?>
					<div class="page-slug service-slug">CreativeForce</div>
				<?php elseif( is_page('nextgenlab')): ?>
					<div class="page-slug service-slug">NextGen .Lab</div>
				<?php elseif( is_page('guardian')): ?>
					<div class="page-slug service-slug">Guardian</div>
				<?php else: ?>
					<div class="page-slug"><?php echo esc_html($slug); ?></div>
				<?php endif; ?>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
		</div>
	</header><!-- .entry-header -->

	<div class="container content-wrapper">
		<div class="row">
			<div class="content-area col-md-12">
				<main id="main" class="post-wrap" role="main">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if(is_page( array( 'about', 'services', 'bizscan', 'creativeforce', 'nextgenlab', 'guardian', 'careers', 'privacy-policy', 'terms', 'contact' ) ) ): ?>

					<div class="entry-content">
						<div class="<?php echo $slug; ?>-page cont-page">
							<?php
								if(is_page('about')){
									include(get_template_directory() . '/template-parts/inc/about-page.php');
								}elseif(is_page('services')){
									include(get_template_directory() . '/template-parts/inc/services-page.php');
								}elseif(is_page('bizscan')){
									include(get_template_directory() . '/template-parts/inc/bizscan-page.php');
								}elseif(is_page('creativeforce')){
									include(get_template_directory() . '/template-parts/inc/creativeforce-page.php');
								}elseif(is_page('nextgenlab')){
									include(get_template_directory() . '/template-parts/inc/nextgenlab-page.php');
								}elseif(is_page('guardian')){
									include(get_template_directory() . '/template-parts/inc/guardian-page.php');
								}elseif(is_page('careers')){
									include(get_template_directory() . '/template-parts/inc/careers-page.php');
								}elseif(is_page('privacy-policy')){
									include(get_template_directory() . '/template-parts/inc/privacy-policy-page.php');
								}elseif(is_page('terms')){
									include(get_template_directory() . '/template-parts/inc/terms-page.php');
								}elseif(is_page('contact')){
									include(get_template_directory() . '/template-parts/inc/contact-page.php');
								}else{

								}
							?>
						</div>
					</div>

					<?php else: ?>
					
					<div class="entry-content">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'andbld' ),
								'after'  => '</div>',
							)
						);
						?>
					</div><!-- .entry-content -->	

					<?php endif; ?>
					</article>
				</main>
			</div>
		</div>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'andbld' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</div>