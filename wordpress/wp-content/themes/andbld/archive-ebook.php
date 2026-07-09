<?php
/**
 * Template for displaying ebook archive
 */

get_header();
?>

<div class="archive-conteiner ebook-container">
    <header class="title-header">
		<div class="row">
			<div class="title-wrap col-md-12">
				<div class="page-slug">ebook</div>
				<h1 class="entry-title">お役立ち資料ダウンロード</h1>
			</div>
		</div>
	</header><!-- .title-header -->

    <div class="container content-wrapper">
		<div class="row">
			<div class="content-area col-md-12">
				<main id="primary" class="site-main col-md-9">

                <?php if (have_posts()) : ?>

                <div class="ebook-grid">
                    <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('ebook-item'); ?>>
                        <div class="ebook-item-inner">
                            <div class="ebook-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-thumbnail.jpg'); ?>" alt="<?php the_title_attribute(); ?>" class="default-ebook-thumbnail" />
                                    <?php endif; ?>
                                </a>
                            </div>

                            <div class="ebook-content">
                                <?php the_title('<h2 class="ebook-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>

                                <div class="ebook-excerpt">
                                    <p>
                                    <?php
                                    $content = get_the_content();
                                    $trimmed_content = wp_trim_words($content, 50, '...');
                                    echo $trimmed_content;
                                    ?>
                                    </p>
                                </div>

                                <div class="ebook-meta">
                                    <a href="<?php the_permalink(); ?>" class="button ebook-more-link">ダウンロード</a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php endwhile; ?>
                </div>

                <?php
                the_posts_pagination(array(
                'prev_text' => '&laquo; 前へ',
                'next_text' => '次へ &raquo;',
                ));
                ?>

                <?php else : ?>
                    <div class="no-ebooks">
                        <p>eBookはまだ登録されていません。</p>
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