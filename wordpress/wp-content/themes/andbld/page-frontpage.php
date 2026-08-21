<?php
/*
Template Name: top-page
*/

/**グローバル変数を定義**/
$dir = get_template_directory();
include($dir. "/custom.php");

get_header();
?>

	<main id="primary" class="site-main">

		<section class="fv-wrap">
      <div class="fv-catch">
        <!-- 背景画像切り替え -->
        <div class="fv-background-changer">
          <div class="fv-bg-image active" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/slide1.webp');">
            <div class="fv-bg-overlay"></div>
          </div>
          <div class="fv-bg-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/slide2.webp');">
            <div class="fv-bg-overlay"></div>
          </div>
          <div class="fv-bg-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/slide3.webp');">
            <div class="fv-bg-overlay"></div>
          </div>
          <div class="fv-bg-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/slide4.webp');">
            <div class="fv-bg-overlay"></div>
          </div>
        </div>
        
        <div class="fv-catch-container">
          <div class="fv-catch-title">
            <p class="fv-catch-title-text1">AI×RPAで、<br class="sp-only">業務革命。</p>
            <p class="fv-catch-title-text2">人を創造に、<br class="sp-only">ロボットを定型に。</p>
          </div>
        </div>
      </div>
		</section>

		<div class="toppage-container container frontpage-container1">
			<div class="row">

        <section class="content-block content-block-whoweare">
          <h2 class="content-title">(WHO WE ARE)</h2>
          <div class="content-text">
            <p>私たちはAIとRPAを駆使して業務を革新し、生産性と効率を飛躍的に高めることで、人々の時間と心に新たな余白を生み出します。</p>
            <p>その余白を未来を切り拓く重要な取り組みや創造的活動へとつなげ、経済的にも時間的にも豊かで、持続可能で明るい未来社会の実現を目指します。</p>
          </div>
        </section>

        <section class="content-block content-block-service">
          <h2 class="content-title">(SERVICE)</h2>
          <div class="content-text">
            <ul class="service-wrap-container-list">
              <li class="service-wrap-container">
                <a href="<?php echo home_url('/services/bizscan/'); ?>" class="service-link">
                  <div class="service-wrap">
                    <p class="service-num">01</p>
                    <p class="service-title">BizScan</p>
                    <p class="service-text">業務プロセス分析と自動化適性診断</p>
                    <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                  </div>
                </a>
              </li>
              <li class="service-wrap-container">
                <a href="<?php echo home_url('/services/creativeforce/'); ?>" class="service-link">
                  <div class="service-wrap">
                    <p class="service-num">02</p>
                    <p class="service-title">CreativeForce</p>
                    <p class="service-text">ソリューション設計・導入</p>
                    <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                  </div>
                </a>
              </li>
              <li class="service-wrap-container">
                <a href="<?php echo home_url('/services/guardian/'); ?>" class="service-link">
                  <div class="service-wrap">
                    <p class="service-num">03</p>
                    <p class="service-title">Guardian</p>
                    <p class="service-text">運用・保守サポート</p>
                    <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                  </div>
                </a>
              </li>
              <li class="service-wrap-container">
                <a href="<?php echo home_url('/services/nextgenlab/'); ?>" class="service-link">
                  <div class="service-wrap">
                    <p class="service-num">04</p>
                    <p class="service-title">NextGen .Lab</p>
                    <p class="service-text">AI×RPA人材の育成プログラム</p>
                    <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </section>

        <section class="content-block content-blog">
          <div class="title-wrap">
            <h2 class="content-title-big">BLOG</h2>
            <a href="<?php echo get_post_type_archive_link('blog'); ?>" class="content-btn"><i class="fas fa-arrow-right"></i>All Blogs</a>
          </div>
          <div class="content-blog-wrap">
            <div class="blog-scroll-container">
              <ul class="blog-list">
              <?php
              $args = array(
                'post_type' => 'blog',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC'
              );
              $the_query = new WP_Query($args);
              
              if ($the_query->have_posts()) :
                $counter = 1;
                while ($the_query->have_posts()) : $the_query->the_post();
                  $category_name = 'Uncategorized';
                  $terms = get_the_terms(get_the_ID(), 'blog_category');
                  if ($terms && !is_wp_error($terms)) {
                    $category_name = esc_html($terms[0]->name);
                  }
              ?>
                <li class="blog-item blog-item-<?php echo $counter; ?>">
                  <a href="<?php the_permalink(); ?>" class="blog-link">
                    <div class="blog-img">
                      <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                      <?php else : ?>
                        <img src="https://picsum.photos/400/300?random=<?php echo $counter; ?>" alt="<?php the_title_attribute(); ?>">
                      <?php endif; ?>
                    </div>
                    <div class="blog-info">
                      <div class="blog-tag-wrap">
                        <p class="blog-tag"><?php echo $category_name; ?></p>
                      </div>
                      <div class="blog-date">
                        <div class="blog-postsdate">
                          <p class="blog-date-text">投稿日 :</p>
                          <p class="blog-date-text"><?php echo get_the_date('Y/m/d'); ?></p>
                        </div>
                      </div>
                    </div>
                    <div class="blog-title">
                      <p><?php the_title(); ?></p>
                    </div>
                  </a>
                </li>
              <?php
                  $counter++;
                endwhile;
                wp_reset_postdata();
              endif;
              ?>
              </ul>
              <button type="button" class="blog-scroll-btn blog-scroll-prev is-hidden" aria-label="前へ"><i class="fas fa-arrow-left" aria-hidden="true"></i></button>
              <button type="button" class="blog-scroll-btn blog-scroll-next" aria-label="次へ"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
            </div><!-- /.blog-scroll-container -->
            <div class="blog-btn-wrap">
              <a href="<?php echo get_post_type_archive_link('blog'); ?>" class="blog-btn">All Blogs<i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </section>

        <section class="content-block content-news">
          <div class="title-wrap">
            <h2 class="content-title-big">NEWS</h2>
            <a href="<?php echo get_post_type_archive_link('post'); ?>" class="content-btn"><i class="fas fa-arrow-right"></i>All News</a>
          </div>
          <div class="content-news-wrap">
            <ul class="news-list">
              <?php
              $args = array(
                'post_type' => 'post',
                'posts_per_page' => 2,
                'orderby' => 'date',
                'order' => 'DESC'
              );
              $news_query = new WP_Query($args);
              
              if ($news_query->have_posts()) :
                $counter = 1;
                while ($news_query->have_posts()) : $news_query->the_post();
                  $category_name = 'Uncategorized';
                  $categories = get_the_category();
                  if (!empty($categories)) {
                    $category_name = esc_html($categories[0]->name);
                  }
              ?>
                <li class="news-item news-item-<?php echo $counter; ?>">
                  <a href="<?php the_permalink(); ?>" class="news-link">
                    <div class="news-info">
                      <div class="news-tag-wrap">
                        <p class="news-tag"><?php echo $category_name; ?></p>
                      </div>
                      <div class="news-date">
                        <div class="news-postsdate">
                          <p class="news-date-text">投稿日 :</p>
                          <p class="news-date-text"><?php echo get_the_date('Y/m/d'); ?></p>
                        </div>
                      </div>
                    </div>
                    <div class="news-title">
                      <p><?php the_title(); ?></p>
                    </div>
                  </a>
                </li>
              <?php
                  $counter++;
                endwhile;
                wp_reset_postdata();
              endif;
              ?>
            </ul>
            <div class="news-btn-wrap">
              <a href="<?php echo get_post_type_archive_link('post'); ?>" class="news-btn">All News<i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </section>

			</div>
		</div>	
	</main><!-- #main -->

<?php
get_footer();
