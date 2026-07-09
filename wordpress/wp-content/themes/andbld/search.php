<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andbld
 */

get_header();
?>

<div class="single-conteiner search-container">
	<div class="container content-wrapper">
		<div class="row">
			<div class="content-area col-md-12">
				<main id="primary" class="site-main col-md-9">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<div class="container">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( '検索結果: %s', 'andbld' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
					<div class="page-description">
						<p><?php echo $wp_query->found_posts; ?>件の結果が見つかりました</p>
					</div>
				</div>
			</header><!-- .page-header -->

			<div class="search-results-container container">
				<div class="search-results-content">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						$post_type = get_post_type();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
						<div class="search-result-content">
							<header class="search-result-header">
								<div class="post-type-badge">
									<?php
									switch ($post_type) {
										case 'glossary':
											echo '<span class="badge glossary-badge">用語集</span>';
											break;
										case 'blog':
											echo '<span class="badge blog-badge">ブログ</span>';
											break;
										case 'ebook':
											echo '<span class="badge ebook-badge">eBook</span>';
											break;
										default:
											echo '<span class="badge post-badge">投稿</span>';
											break;
									}
									?>
								</div>
								<h2 class="search-result-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
							</header>

							<div class="search-result-excerpt">
								<?php if (has_excerpt()) : ?>
									<?php the_excerpt(); ?>
								<?php else : ?>
									<?php echo wp_trim_words(get_the_content(), 100, '...'); ?>
								<?php endif; ?>
							</div>

							<footer class="search-result-footer">
								<div class="search-result-meta">
									<?php if ($post_type === 'glossary') : ?>
										<?php
										$categories = get_the_terms(get_the_ID(), 'glossary_category');
										if ($categories && !is_wp_error($categories)) :
										?>
										<div class="glossary-categories">
											<?php foreach ($categories as $category) : ?>
											<span class="category-tag"><?php echo $category->name; ?></span>
											<?php endforeach; ?>
										</div>
										<?php endif; ?>
									<?php elseif ($post_type === 'blog') : ?>
										<?php
										$categories = get_the_terms(get_the_ID(), 'blog_category');
										if ($categories && !is_wp_error($categories)) :
										?>
										<div class="blog-categories">
											<?php foreach ($categories as $category) : ?>
											<span class="category-tag"><?php echo $category->name; ?></span>
											<?php endforeach; ?>
										</div>
										<?php endif; ?>
									<?php else : ?>
										<?php
										$categories = get_the_category();
										if (!empty($categories)) :
										?>
										<div class="post-categories">
											<?php foreach ($categories as $category) : ?>
											<span class="category-tag"><?php echo $category->name; ?></span>
											<?php endforeach; ?>
										</div>
										<?php endif; ?>
									<?php endif; ?>
									
									<span class="post-date"><?php echo get_the_date('Y/m/d'); ?></span>
								</div>
								<a href="<?php the_permalink(); ?>" class="read-more">詳細を見る</a>
							</footer>
						</div>
					</article>

					<?php
					endwhile;
					?>

					<?php
					// ページネーション
					the_posts_pagination(array(
						'mid_size' => 2,
						'prev_text' => '前へ',
						'next_text' => '次へ',
					));
					?>

				</div>
			</div>

		<?php else : ?>

			<div class="container">
				<div class="no-search-results">
					<h2>検索結果が見つかりませんでした</h2>
					<p>「<?php echo get_search_query(); ?>」に一致する結果がありませんでした。</p>
					<div class="search-suggestions">
						<h3>検索のヒント</h3>
						<ul>
							<li>キーワードのスペルを確認してください</li>
							<li>より一般的なキーワードを試してください</li>
							<li>キーワードの数を減らしてください</li>
							<li>用語集から探してみてください</li>
						</ul>
					</div>
					<div class="search-actions">
						<a href="<?php echo home_url('/glossary/'); ?>" class="btn-glossary">用語集を見る</a>
						<a href="<?php echo home_url('/'); ?>" class="btn-home">ホームに戻る</a>
					</div>
				</div>
			</div>

		<?php endif; ?>

			</main><!-- #main -->
			<div class="sidebar-area col-md-2">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
