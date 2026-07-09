<?php
/**
 * Template for displaying single ebook posts
 */

get_header();
?>

<div class="single-conteiner ebook-container">
	<div class="container content-wrapper">
		<div class="row">
			<div class="content-area col-md-12">
				<main id="primary" class="site-main col-md-5">
                    <?php while (have_posts()) : the_post(); ?>
                         <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                              <header class="entry-header">
                                   <?php the_title('<h1 class="entry-title">「', '」ダウンロード</h1>'); ?>
                              </header>

                              <div class="entry-content">
                                   <div class="ebook-cover">
                                   <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large'); ?>
                                   <?php else : ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-thumbnail.jpg'); ?>" alt="<?php the_title_attribute(); ?>" class="default-ebook-thumbnail" />
                                   <?php endif; ?>
                                   </div>

                                   <div class="ebook-content-wrap">
                                        <?php the_content(); ?>
                                   </div>
                              </div>

                              <div class="ebook-message-content">
                                   <p>フォーム送信完了後、ダウンロードURL付きのメールをお送りします。</p>
                              </div>
                         </article>
                    <?php endwhile; ?>
				</main><!-- #main -->
				<div class="sideform-area col-md-6">
                         <?php echo do_shortcode('[contact-form-7 id="0308e9d" title="コンタクトフォーム 1"]'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();