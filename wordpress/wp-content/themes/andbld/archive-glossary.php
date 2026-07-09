<?php
/**
 * The template for displaying glossary archive pages
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
                <div class="page-slug"><?php
                        if (is_category()) {
                            echo esc_html(get_queried_object()->slug);
                        } else {
                            echo 'glossary';
                        }
                    ?></div>
                    <h1 class="entry-title"><?php
                        if (is_category()) {
                            echo esc_html(single_cat_title('', false));
                        } else {
                            echo '用語集';
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

						<?php if (is_tax('glossary_category')) : ?>
						<div class="glossary-category-header">
							<h2><?php single_term_title(); ?></h2>
							<?php if (term_description()) : ?>
							<div class="category-description">
								<?php echo term_description(); ?>
							</div>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<div class="glossary-list">
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
							?>
						</div>

						<?php
						the_posts_navigation();
						?>

					<?php else : ?>

						<div class="no-glossary-found">
							<h2>用語が見つかりませんでした</h2>
							<p>検索条件に一致する用語がありませんでした。別のキーワードで検索するか、カテゴリーから選択してください。</p>
							<a href="<?php echo get_post_type_archive_link('glossary'); ?>" class="btn-back-to-glossary">用語集一覧に戻る</a>
						</div>

					<?php endif; ?>

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