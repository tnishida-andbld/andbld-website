<?php
/**
 * andbld functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package andbld
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function andbld_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on andbld, use a find and replace
		* to change 'andbld' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'andbld', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Primary', 'andbld' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'andbld_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'andbld_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function andbld_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'andbld_content_width', 640 );
}
add_action( 'after_setup_theme', 'andbld_content_width', 0 );


/** Original custom **/

/**
 *Load Bootstrap file.
*/

function my_bootstrap_scripts() {
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_bootstrap_scripts' );

/**
 *Load jquery file.
*/

function my_script() {
	wp_deregister_script('jquery');
	wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-3.7.1.min.js', array(), '3.7.1');
}
add_action( 'wp_enqueue_scripts', 'my_script' );

/*
 *Load JavaScript file.
*/

function my_scripts() {
	wp_enqueue_script( 'header', get_template_directory_uri() . '/js/header.js', array(), false, true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array(), false, true );
	wp_enqueue_script( 'image-slider', get_template_directory_uri() . '/js/image-slider.js', array(), false, true );
	wp_enqueue_script( 'glossary-accordion', get_template_directory_uri() . '/js/glossary-accordion.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'my_scripts');

/*
 *Load css file.
*/

function my_styles() {
	wp_enqueue_style( 'my-font-awesome-style', 'https://use.fontawesome.com/releases/v5.12.0/css/all.css', array(), '5.12.0' );
	wp_enqueue_style( 'bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css' );
}
add_action( 'wp_enqueue_scripts', 'my_styles' );

/*
 *用語集用CSSファイルを読み込み
*/
function load_glossary_styles() {
    if (is_post_type_archive('glossary') || is_singular('glossary') || is_tax('glossary_category') || is_tax('glossary_tag')) {
        wp_enqueue_style('glossary-style', get_template_directory_uri() . '/css/glossary.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'load_glossary_styles');

/*
 *カスタム投稿タイプ追加（ブログ）
*/

function register_custom_post_type() {
  register_post_type('blog',
    array(
      'labels' => array(
        'name' => 'ブログ',
        'singular_name' => 'ブログ'
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'blogs'),
      'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
      'menu_position' => 5,
      'menu_icon' => 'dashicons-portfolio'
    )
  );

  // ブログ用カスタムタクソノミーを登録
  register_taxonomy(
    'blog_category',
    'blog',
    array(
      'labels' => array(
        'name' => 'ブログカテゴリー',
        'singular_name' => 'ブログカテゴリー'
      ),
      'hierarchical' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'blog-category')
    )
  );
}
add_action('init', 'register_custom_post_type');

/**
 *カスタム投稿タイプ追加（eBook）
*/

// eBookカスタム投稿タイプを登録
function register_ebook_post_type() {
    $labels = array(
        'name'              => 'eBooks',
        'singular_name'     => 'eBook',
        'menu_name'         => 'eBooks',
        'add_new'           => '新規追加',
        'add_new_item'      => '新規eBookを追加',
        'edit_item'         => 'eBookを編集',
        'new_item'          => '新規eBook',
        'view_item'         => 'eBookを表示',
        'search_items'      => 'eBookを検索',
        'not_found'         => 'eBookが見つかりませんでした',
        'not_found_in_trash'=> 'ゴミ箱にeBookはありません',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'ebooks'),
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-book-alt',
        'supports'            => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('ebook', $args);
}
add_action('init', 'register_ebook_post_type');

/**
 *カスタム投稿タイプ追加（用語集）
*/

// 用語集カスタム投稿タイプを登録
function register_glossary_post_type() {
    $labels = array(
        'name'              => '用語集',
        'singular_name'     => '用語',
        'menu_name'         => '用語集',
        'add_new'           => '新規追加',
        'add_new_item'      => '新規用語を追加',
        'edit_item'         => '用語を編集',
        'new_item'          => '新規用語',
        'view_item'         => '用語を表示',
        'search_items'      => '用語を検索',
        'not_found'         => '用語が見つかりませんでした',
        'not_found_in_trash'=> 'ゴミ箱に用語はありません',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'glossary'),
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-editor-spellcheck',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_position'       => 6,
    );

    register_post_type('glossary', $args);
}
add_action('init', 'register_glossary_post_type');

/**
 *用語集用カスタムタクソノミーを登録
*/

function register_glossary_taxonomies() {
    // 用語カテゴリー
    register_taxonomy(
        'glossary_category',
        'glossary',
        array(
            'labels' => array(
                'name' => '用語カテゴリー',
                'singular_name' => '用語カテゴリー',
                'search_items' => 'カテゴリーを検索',
                'all_items' => 'すべてのカテゴリー',
                'parent_item' => '親カテゴリー',
                'parent_item_colon' => '親カテゴリー:',
                'edit_item' => 'カテゴリーを編集',
                'update_item' => 'カテゴリーを更新',
                'add_new_item' => '新規カテゴリーを追加',
                'new_item_name' => '新規カテゴリー名',
                'menu_name' => 'カテゴリー',
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'glossary-category'),
            'show_in_rest' => true,
        )
    );

    // 用語タグ
    register_taxonomy(
        'glossary_tag',
        'glossary',
        array(
            'labels' => array(
                'name' => '用語タグ',
                'singular_name' => '用語タグ',
                'search_items' => 'タグを検索',
                'all_items' => 'すべてのタグ',
                'edit_item' => 'タグを編集',
                'update_item' => 'タグを更新',
                'add_new_item' => '新規タグを追加',
                'new_item_name' => '新規タグ名',
                'menu_name' => 'タグ',
            ),
            'hierarchical' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'glossary-tag'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'register_glossary_taxonomies');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function andbld_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'andbld' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'andbld' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'andbld_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function andbld_scripts() {
	wp_enqueue_style( 'andbld-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'andbld-style', 'rtl', 'replace' );

	wp_enqueue_script( 'andbld-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'andbld_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Set default thumbnail for posts without featured image
 */
function andbld_default_post_thumbnail() {
    // デフォルトサムネイルのパスを設定
    $default_thumb = get_template_directory_uri() . '/assets/images/default-thumbnail.jpg';
    
    // アイキャッチ画像が設定されていない場合
    if (!has_post_thumbnail()) {
        return $default_thumb;
    }
    
    return get_the_post_thumbnail_url(null, 'full');
}

/**
 * Add custom image sizes
 */
function andbld_add_image_sizes() {
    // ブログサムネイル用のカスタムサイズを追加
    add_image_size('blog-thumbnail', 1200, 630, true);
}
add_action('after_setup_theme', 'andbld_add_image_sizes');

/**
 * ブログ最新記事ウィジェット
 */
class Blog_Recent_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'blog_recent_posts_widget',
            'ブログ最新記事',
            array('description' => 'ブログの最新記事を表示します')
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $title = !empty($instance['title']) ? $instance['title'] : 'ブログ最新記事';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        $blog_posts = new WP_Query(array(
            'post_type' => 'blog',
            'posts_per_page' => $number,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        if ($blog_posts->have_posts()) {
            echo '<ul class="blog-recent-posts">';
            while ($blog_posts->have_posts()) {
                $blog_posts->the_post();
                echo '<li class="blog-recent-post-item">';
                echo '<a href="' . get_permalink() . '">';
                echo '<div class="blog-content">';
                echo '<h4 class="blog-title">' . get_the_title() . '</h4>';
                echo '<span class="blog-date">' . get_the_date() . '</span>';
                echo '</div>';
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p>記事がありません。</p>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'ブログ最新記事';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">タイトル:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">表示件数:</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

/**
 * ブログカテゴリーウィジェット
 */
class Blog_Categories_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'blog_categories_widget',
            'ブログカテゴリー',
            array('description' => 'ブログのカテゴリー一覧を表示します')
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $title = !empty($instance['title']) ? $instance['title'] : 'ブログカテゴリー';
        
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        $categories = get_terms(array(
            'taxonomy' => 'blog_category',
            'hide_empty' => true,
        ));
        
        if (!empty($categories) && !is_wp_error($categories)) {
            echo '<ul class="blog-categories-list">';
            foreach ($categories as $category) {
                $category_link = get_term_link($category);
                if (!is_wp_error($category_link)) {
                    echo '<li class="blog-category-item">';
                    echo '<a href="' . esc_url($category_link) . '">';
                    echo esc_html($category->name);
                    echo '<span class="category-count">(' . $category->count . ')</span>';
                    echo '</a>';
                    echo '</li>';
                }
            }
            echo '</ul>';
        } else {
            echo '<p>カテゴリーがありません。</p>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'ブログカテゴリー';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">タイトル:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * ウィジェットを登録
 */
function register_blog_widgets() {
    register_widget('Blog_Recent_Posts_Widget');
    register_widget('Blog_Categories_Widget');
}
add_action('widgets_init', 'register_blog_widgets');

/**
 * キーワード自動リンク機能
 */

// キーワード管理用のカスタム投稿タイプを登録
function register_keyword_post_type() {
    $labels = array(
        'name'              => 'キーワード',
        'singular_name'     => 'キーワード',
        'menu_name'         => 'キーワード管理',
        'add_new'           => '新規追加',
        'add_new_item'      => '新規キーワードを追加',
        'edit_item'         => 'キーワードを編集',
        'new_item'          => '新規キーワード',
        'view_item'         => 'キーワードを表示',
        'search_items'      => 'キーワードを検索',
        'not_found'         => 'キーワードが見つかりませんでした',
        'not_found_in_trash'=> 'ゴミ箱にキーワードはありません',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-admin-links',
        'supports'            => array('title', 'editor'),
        'menu_position'       => 20,
    );

    register_post_type('keyword', $args);
}
add_action('init', 'register_keyword_post_type');

// キーワードのメタボックスを追加
function add_keyword_meta_boxes() {
    add_meta_box(
        'keyword_url',
        'リンク先URL',
        'keyword_url_callback',
        'keyword',
        'normal',
        'high'
    );
    
    add_meta_box(
        'keyword_exclude_pages',
        '自動リンク除外ページ',
        'keyword_exclude_pages_callback',
        'keyword',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_keyword_meta_boxes');

// キーワードURL入力フィールド
function keyword_url_callback($post) {
    wp_nonce_field('keyword_url_nonce', 'keyword_url_nonce');
    $url = get_post_meta($post->ID, '_keyword_url', true);
    
    // 現在のサイトURLを取得
    $site_url = get_site_url();
    $site_domain = parse_url($site_url, PHP_URL_HOST);
    $site_scheme = parse_url($site_url, PHP_URL_SCHEME);
    
    // 相対パスを抽出（ドメイン部分を除去）
    $relative_path = '';
    if (!empty($url)) {
        $parsed_url = parse_url($url);
        if (isset($parsed_url['host']) && $parsed_url['host'] === $site_domain) {
            $relative_path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
            if (isset($parsed_url['query'])) {
                $relative_path .= '?' . $parsed_url['query'];
            }
            if (isset($parsed_url['fragment'])) {
                $relative_path .= '#' . $parsed_url['fragment'];
            }
        } else {
            // 外部URLの場合はそのまま表示
            $relative_path = $url;
        }
    }
    ?>
    <p>
        <label for="keyword_url">リンク先URL (相対パス):</label><br>
        <input type="text" id="keyword_url" name="keyword_url" value="<?php echo esc_attr($relative_path); ?>" style="width: 100%;" placeholder="/page-name/">
        <p class="description">
            <strong>サイト内リンク:</strong> 相対パスを入力してください（例: /about/, /blog/post-name/）<br>
            <strong>外部リンク:</strong> 完全なURLを入力してください（例: https://example.com/page）
        </p>
        <p class="description">
            <strong>現在のサイトURL:</strong> <?php echo esc_html($site_url); ?>
        </p>
    </p>
    <?php
}

// キーワードURLを保存
function save_keyword_url($post_id) {
    if (!isset($_POST['keyword_url_nonce']) || !wp_verify_nonce($_POST['keyword_url_nonce'], 'keyword_url_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['keyword_url'])) {
        $input_url = trim($_POST['keyword_url']);
        
        // 空の場合は何もしない
        if (empty($input_url)) {
            delete_post_meta($post_id, '_keyword_url');
        } else {
            // 完全なURL（http:// または https:// で始まる）の場合はそのまま保存
            if (preg_match('/^https?:\/\//', $input_url)) {
                update_post_meta($post_id, '_keyword_url', sanitize_url($input_url));
            } else {
                // 相対パスの場合、サイトURLと結合
                $site_url = get_site_url();
                
                // 先頭のスラッシュを確認
                if (strpos($input_url, '/') !== 0) {
                    $input_url = '/' . $input_url;
                }
                
                $full_url = $site_url . $input_url;
                update_post_meta($post_id, '_keyword_url', sanitize_url($full_url));
            }
        }
    }
    
    // 除外ページの保存
    if (isset($_POST['keyword_exclude_pages_nonce']) && wp_verify_nonce($_POST['keyword_exclude_pages_nonce'], 'keyword_exclude_pages_nonce')) {
        if (isset($_POST['keyword_exclude_pages'])) {
            $exclude_pages_text = trim($_POST['keyword_exclude_pages']);
            
            if (empty($exclude_pages_text)) {
                delete_post_meta($post_id, '_keyword_exclude_pages');
            } else {
                // 改行で分割して配列に変換
                $exclude_pages = array_filter(array_map('trim', explode("\n", $exclude_pages_text)));
                
                // URLを正規化
                $normalized_pages = array();
                foreach ($exclude_pages as $page) {
                    if (!empty($page)) {
                        // 完全なURLの場合はそのまま保存
                        if (preg_match('/^https?:\/\//', $page)) {
                            $normalized_pages[] = sanitize_url($page);
                        } else {
                            // 相対パスの場合、サイトURLと結合
                            $site_url = get_site_url();
                            
                            // 先頭のスラッシュを確認
                            if (strpos($page, '/') !== 0) {
                                $page = '/' . $page;
                            }
                            
                            $full_url = $site_url . $page;
                            $normalized_pages[] = sanitize_url($full_url);
                        }
                    }
                }
                
                update_post_meta($post_id, '_keyword_exclude_pages', $normalized_pages);
            }
        }
    }
}
add_action('save_post', 'save_keyword_url');

// キーワードをキャッシュして取得
function get_cached_keywords() {
    $keywords = wp_cache_get('auto_link_keywords');
    
    if (false === $keywords) {
        $keyword_posts = get_posts(array(
            'post_type' => 'keyword',
            'numberposts' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ));
        
        $keywords = array();
        foreach ($keyword_posts as $post) {
            $url = get_post_meta($post->ID, '_keyword_url', true);
            $exclude_pages = get_post_meta($post->ID, '_keyword_exclude_pages', true);
            
            if (!empty($url)) {
                $keywords[$post->post_title] = array(
                    'url' => $url,
                    'exclude_pages' => is_array($exclude_pages) ? $exclude_pages : array()
                );
            }
        }
        
        wp_cache_set('auto_link_keywords', $keywords, '', 3600); // 1時間キャッシュ
    }
    
    return $keywords;
}


add_filter('the_content', 'auto_link_keywords_with_settings', 20);
add_filter('the_excerpt', 'auto_link_keywords_with_settings', 5);
add_filter('the_title', 'auto_link_keywords_with_settings', 5);

// キーワードが更新されたらキャッシュをクリア
function clear_keyword_cache($post_id) {
    if (get_post_type($post_id) === 'keyword') {
        wp_cache_delete('auto_link_keywords');
    }
}
add_action('save_post', 'clear_keyword_cache');
add_action('delete_post', 'clear_keyword_cache');

// キャッシュを手動でクリアする関数
function clear_keyword_cache_manual() {
    wp_cache_delete('auto_link_keywords');
    return true;
}

// 管理画面にキャッシュクリアボタンを追加
function add_keyword_cache_clear_button() {
    global $post_type;
    if ($post_type === 'keyword') {
        ?>
        <div class="notice notice-info">
            <p>
                <strong>キーワード自動リンク機能:</strong> 
                キーワードを変更した場合は、キャッシュをクリアしてください。
                <a href="<?php echo admin_url('admin-ajax.php?action=clear_keyword_cache'); ?>" class="button button-secondary">キャッシュをクリア</a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'add_keyword_cache_clear_button');

// AJAXでキャッシュクリア
function ajax_clear_keyword_cache() {
    if (current_user_can('manage_options')) {
        clear_keyword_cache_manual();
        wp_die('キャッシュをクリアしました。');
    }
}
add_action('wp_ajax_clear_keyword_cache', 'ajax_clear_keyword_cache');

// キーワード管理画面のカスタマイズ
function customize_keyword_admin() {
    global $post_type;
    if ($post_type === 'keyword') {
        ?>
        <style>
        .post-type-keyword .wp-editor-wrap {
            margin-top: 10px;
        }
        .post-type-keyword #keyword_url {
            font-size: 14px;
            padding: 8px;
        }
        </style>
        <?php
    }
}
add_action('admin_head', 'customize_keyword_admin');

// キーワード一覧のカラムを追加
function add_keyword_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['keyword_url'] = 'リンク先URL';
            $new_columns['exclude_pages'] = '除外ページ';
        }
    }
    return $new_columns;
}
add_filter('manage_keyword_posts_columns', 'add_keyword_columns');

// キーワード一覧のカラム内容を表示
function show_keyword_columns($column, $post_id) {
    if ($column === 'keyword_url') {
        $url = get_post_meta($post_id, '_keyword_url', true);
        if (!empty($url)) {
            // サイト内リンクの場合は相対パスで表示
            $site_url = get_site_url();
            $site_domain = parse_url($site_url, PHP_URL_HOST);
            $parsed_url = parse_url($url);
            
            $display_url = $url;
            if (isset($parsed_url['host']) && $parsed_url['host'] === $site_domain) {
                $display_url = isset($parsed_url['path']) ? $parsed_url['path'] : '';
                if (isset($parsed_url['query'])) {
                    $display_url .= '?' . $parsed_url['query'];
                }
                if (isset($parsed_url['fragment'])) {
                    $display_url .= '#' . $parsed_url['fragment'];
                }
            }
            
            echo '<a href="' . esc_url($url) . '" target="_blank">' . esc_html($display_url) . '</a>';
        } else {
            echo '<span style="color: #999;">未設定</span>';
        }
    }
    
    if ($column === 'exclude_pages') {
        $exclude_pages = get_post_meta($post_id, '_keyword_exclude_pages', true);
        if (!empty($exclude_pages) && is_array($exclude_pages)) {
            $site_url = get_site_url();
            $site_domain = parse_url($site_url, PHP_URL_HOST);
            
            $display_pages = array();
            foreach ($exclude_pages as $page) {
                $parsed_url = parse_url($page);
                
                $display_page = $page;
                if (isset($parsed_url['host']) && $parsed_url['host'] === $site_domain) {
                    $display_page = isset($parsed_url['path']) ? $parsed_url['path'] : '';
                    if (isset($parsed_url['query'])) {
                        $display_page .= '?' . $parsed_url['query'];
                    }
                    if (isset($parsed_url['fragment'])) {
                        $display_page .= '#' . $parsed_url['fragment'];
                    }
                }
                
                $display_pages[] = $display_page;
            }
            
            echo '<span style="color: #d63638;">' . esc_html(implode(', ', $display_pages)) . '</span>';
        } else {
            echo '<span style="color: #999;">なし</span>';
        }
    }
}
add_action('manage_keyword_posts_custom_column', 'show_keyword_columns', 10, 2);

// キーワード一覧のカラムをソート可能にする
function make_keyword_columns_sortable($columns) {
    $columns['keyword_url'] = 'keyword_url';
    return $columns;
}
add_filter('manage_edit-keyword_sortable_columns', 'make_keyword_columns_sortable');

// キーワード検索機能を追加
function add_keyword_search_filter() {
    global $typenow;
    if ($typenow === 'keyword') {
        ?>
        <select name="keyword_search">
            <option value="">すべてのキーワード</option>
            <option value="with_url" <?php selected($_GET['keyword_search'], 'with_url'); ?>>URL設定済み</option>
            <option value="without_url" <?php selected($_GET['keyword_search'], 'without_url'); ?>>URL未設定</option>
        </select>
        <?php
    }
}
add_action('restrict_manage_posts', 'add_keyword_search_filter');

// キーワード検索フィルターを処理
function filter_keywords_by_url_status($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    if ($query->get('post_type') !== 'keyword') {
        return;
    }
    
    if (isset($_GET['keyword_search'])) {
        if ($_GET['keyword_search'] === 'with_url') {
            $query->set('meta_query', array(
                array(
                    'key' => '_keyword_url',
                    'compare' => 'EXISTS',
                    'value' => ''
                )
            ));
        } elseif ($_GET['keyword_search'] === 'without_url') {
            $query->set('meta_query', array(
                array(
                    'key' => '_keyword_url',
                    'compare' => 'NOT EXISTS'
                )
            ));
        }
    }
}
add_action('pre_get_posts', 'filter_keywords_by_url_status');

/**
 * キーワード自動リンク設定ページ
 */

// 設定ページを追加
function add_keyword_settings_page() {
    add_options_page(
        'キーワード自動リンク設定',
        'キーワード自動リンク',
        'manage_options',
        'keyword-auto-link-settings',
        'keyword_settings_page_callback'
    );
}
add_action('admin_menu', 'add_keyword_settings_page');

// 設定ページのコールバック関数
function keyword_settings_page_callback() {
    // 設定を保存
    if (isset($_POST['submit'])) {
        update_option('keyword_auto_link_enabled', isset($_POST['keyword_auto_link_enabled']) ? 1 : 0);
        update_option('keyword_auto_link_post_types', isset($_POST['post_types']) ? $_POST['post_types'] : array());
        update_option('keyword_auto_link_max_per_post', intval($_POST['max_per_post']));
        echo '<div class="notice notice-success"><p>設定を保存しました。</p></div>';
    }
    
    $enabled = get_option('keyword_auto_link_enabled', 1);
    $post_types = get_option('keyword_auto_link_post_types', array('post', 'page', 'blog', 'glossary'));
    $max_per_post = get_option('keyword_auto_link_max_per_post', 500);
    
    $available_post_types = array(
        'post' => '投稿',
        'page' => '固定ページ',
        'blog' => 'ブログ',
        'glossary' => '用語集'
    );
    ?>
    <div class="wrap">
        <h1>キーワード自動リンク設定</h1>
        
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">自動リンク機能</th>
                    <td>
                        <label>
                            <input type="checkbox" name="keyword_auto_link_enabled" value="1" <?php checked($enabled, 1); ?>>
                            キーワード自動リンクを有効にする
                        </label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">対象投稿タイプ</th>
                    <td>
                        <?php foreach ($available_post_types as $type => $label): ?>
                            <label style="display: block; margin-bottom: 5px;">
                                <input type="checkbox" name="post_types[]" value="<?php echo esc_attr($type); ?>" <?php checked(in_array($type, $post_types)); ?>>
                                <?php echo esc_html($label); ?>
                            </label>
                        <?php endforeach; ?>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">1記事あたりの最大リンク数</th>
                    <td>
                        <input type="number" name="max_per_post" value="<?php echo esc_attr($max_per_post); ?>" min="1" max="500" style="width: 100px;">
                        <p class="description">1つの記事内で自動リンク化するキーワードの最大数を設定します。（最大500）</p>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="設定を保存">
            </p>
        </form>
        
        <hr>
        
        <h2>使用方法</h2>
        <ol>
            <li>管理画面の「キーワード管理」からキーワードを登録します。</li>
            <li>各キーワードにリンク先URLを設定します。</li>
            <li>記事内に登録したキーワードが含まれていると、自動的にリンク化されます。</li>
        </ol>
        
        <h2>統計情報</h2>
        <?php
        $keyword_count = wp_count_posts('keyword');
        $published_keywords = $keyword_count->publish;
        $total_keywords = $keyword_count->publish + $keyword_count->draft + $keyword_count->pending;
        ?>
        <p>登録済みキーワード数: <strong><?php echo $published_keywords; ?></strong> (公開済み) / <strong><?php echo $total_keywords; ?></strong> (合計)</p>
    </div>
    <?php
}

// 設定に基づいて自動リンク機能を制御
function auto_link_keywords_with_settings($content) {
    // デバッグ用ログ
    if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
        error_log('auto_link_keywords_with_settings called with content length: ' . strlen($content));
    }
    
    // 空のコンテンツの場合は何もしない
    if (empty($content)) {
        return $content;
    }
    
    // 機能が無効化されている場合は何もしない
    if (!get_option('keyword_auto_link_enabled', 1)) {
        if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
            error_log('Keyword auto-link is disabled');
        }
        return $content;
    }
    
    // 管理画面では実行しない
    if (is_admin()) {
        if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
            error_log('In admin area, skipping auto-link');
        }
        return $content;
    }
    
    // 設定された投稿タイプでのみ実行
    $enabled_post_types = get_option('keyword_auto_link_post_types', array('post', 'page', 'blog', 'glossary'));
    if (!is_singular($enabled_post_types) && !is_archive()) {
        if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
            error_log('Not on enabled post types or archive');
        }
        return $content;
    }
    
    $keywords = get_cached_keywords();
    
    if (empty($keywords)) {
        if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
            error_log('No keywords found');
        }
        return $content;
    }
    
    if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
        error_log('Processing keywords: ' . count($keywords));
    }
    
    // 現在のページURLを取得
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    // キーワードを長い順にソート
    uksort($keywords, function($a, $b) {
        return strlen($b) - strlen($a);
    });
    
    $max_per_post = get_option('keyword_auto_link_max_per_post', 500);
    $link_count = 0;
    $processed_words = array();
    
    // report-in-contentsクラス内のsectionタグを処理
    $content = preg_replace_callback(
        '/<section[^>]*class="[^"]*report-in-contents[^"]*"[^>]*>(.*?)<\/section>/is',
        function($matches) use ($keywords, $max_per_post, &$link_count, &$processed_words, $current_url) {
            $section_content = $matches[1];
            
            // section内のpタグのみを処理
            $section_content = preg_replace_callback(
                '/<p[^>]*>(.*?)<\/p>/is',
                function($p_matches) use ($keywords, $max_per_post, &$link_count, &$processed_words, $current_url) {
                    $p_content = $p_matches[1];
                    
                    // 既存のリンクを一時的に置換
                    $existing_links = array();
                    $p_content = preg_replace_callback(
                        '/<a[^>]*>.*?<\/a>/is',
                        function($link_matches) use (&$existing_links) {
                            $placeholder = '###LINK_' . count($existing_links) . '###';
                            $existing_links[$placeholder] = $link_matches[0];
                            return $placeholder;
                        },
                        $p_content
                    );
                    
                    // キーワードを置換
                    foreach ($keywords as $keyword => $data) {
                        // 最大リンク数に達したら停止
                        if ($link_count >= $max_per_post) {
                            break;
                        }
                        
                        // 既に処理済みのキーワードはスキップ
                        if (in_array($keyword, $processed_words)) {
                            continue;
                        }
                        
                        // 除外ページチェック
                        $exclude_pages = isset($data['exclude_pages']) ? $data['exclude_pages'] : array();
                        $is_excluded = false;
                        
                        foreach ($exclude_pages as $exclude_page) {
                            if (strpos($current_url, $exclude_page) !== false) {
                                $is_excluded = true;
                                break;
                            }
                        }
                        
                        // 除外ページの場合はスキップ
                        if ($is_excluded) {
                            continue;
                        }
                        
                        // キーワードを検索して置換
                        $pattern = '/\b' . preg_quote($keyword, '/') . '\b/i';
                        $p_content = preg_replace_callback($pattern, function($matches) use ($data, $keyword, &$link_count) {
                            $word = $matches[0];
                            
                            // リンク化
                            $link_count++;
                            if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
                                error_log('Replacing keyword: ' . $keyword . ' with link to: ' . $data['url']);
                            }
                            return '<a href="' . esc_url($data['url']) . '" class="auto-link-keyword" title="' . esc_attr($keyword) . '">' . $word . '</a>';
                        }, $p_content);
                        
                        $processed_words[] = $keyword;
                    }
                    
                    // 既存のリンクを復元
                    foreach ($existing_links as $placeholder => $original_link) {
                        $p_content = str_replace($placeholder, $original_link, $p_content);
                    }
                    
                    return '<p' . (preg_match('/<p([^>]*)>/', $p_matches[0], $p_attrs) ? $p_attrs[1] : '') . '>' . $p_content . '</p>';
                },
                $section_content
            );
            
            return '<section' . (preg_match('/<section([^>]*)>/', $matches[0], $section_attrs) ? $section_attrs[1] : '') . '>' . $section_content . '</section>';
        },
        $content
    );
    
    if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
        error_log('Auto-link processing completed. Links added: ' . $link_count);
    }
    
    return $content;
}

// 古い関数を削除し、新しい関数を登録（優先度を高く設定）
remove_filter('the_content', 'auto_link_keywords', 20);
remove_filter('the_content', 'auto_link_keywords_with_settings', 10);

// 複数のフックに追加して確実に動作するようにする
add_filter('the_content', 'auto_link_keywords_with_settings', 5);
add_filter('the_excerpt', 'auto_link_keywords_with_settings', 5);

// シンプルなテスト用キーワード置換関数
function simple_keyword_replace($content) {
    $keywords = get_cached_keywords();
    
    if (empty($keywords)) {
        return $content;
    }
    
    foreach ($keywords as $keyword => $data) {
        $content = str_ireplace($keyword, '<a href="' . esc_url($data['url']) . '" class="auto-link-keyword">' . $keyword . '</a>', $content);
    }
    
    return $content;
}

// より確実なキーワード自動リンク機能
function reliable_auto_link_keywords($content) {
    // 機能が無効化されている場合は何もしない
    if (!get_option('keyword_auto_link_enabled', 1)) {
        return $content;
    }
    
    // 管理画面では実行しない
    if (is_admin()) {
        return $content;
    }
    
    // 設定された投稿タイプでのみ実行
    $enabled_post_types = get_option('keyword_auto_link_post_types', array('post', 'page', 'blog', 'glossary'));
    if (!is_singular($enabled_post_types) && !is_archive()) {
        return $content;
    }
    
    $keywords = get_cached_keywords();
    
    if (empty($keywords)) {
        return $content;
    }
    
    // 現在のページURLを取得
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    // キーワードを長い順にソート
    uksort($keywords, function($a, $b) {
        return strlen($b) - strlen($a);
    });
    
    $max_per_post = get_option('keyword_auto_link_max_per_post', 500);
    $link_count = 0;
    
    // report-in-contentsクラス内のsectionタグを処理
    $content = preg_replace_callback(
        '/<section[^>]*class="[^"]*report-in-contents[^"]*"[^>]*>(.*?)<\/section>/is',
        function($matches) use ($keywords, $max_per_post, &$link_count, $current_url) {
            $section_content = $matches[1];
            
            // section内のpタグのみを処理
            $section_content = preg_replace_callback(
                '/<p[^>]*>(.*?)<\/p>/is',
                function($p_matches) use ($keywords, $max_per_post, &$link_count, $current_url) {
                    $p_content = $p_matches[1];
                    
                    // 既存のリンクを一時的に置換
                    $existing_links = array();
                    $p_content = preg_replace_callback(
                        '/<a[^>]*>.*?<\/a>/is',
                        function($link_matches) use (&$existing_links) {
                            $placeholder = '###LINK_' . count($existing_links) . '###';
                            $existing_links[$placeholder] = $link_matches[0];
                            return $placeholder;
                        },
                        $p_content
                    );
                    
                    // キーワードを置換
                    foreach ($keywords as $keyword => $data) {
                        if ($link_count >= $max_per_post) {
                            break;
                        }
                        
                        // 除外ページチェック
                        $exclude_pages = isset($data['exclude_pages']) ? $data['exclude_pages'] : array();
                        $is_excluded = false;
                        
                        foreach ($exclude_pages as $exclude_page) {
                            if (strpos($current_url, $exclude_page) !== false) {
                                $is_excluded = true;
                                break;
                            }
                        }
                        
                        // 除外ページの場合はスキップ
                        if ($is_excluded) {
                            continue;
                        }
                        
                        // 単純な文字列置換
                        $replacement = '<a href="' . esc_url($data['url']) . '" class="auto-link-keyword">' . $keyword . '</a>';
                        $new_p_content = str_ireplace($keyword, $replacement, $p_content);
                        
                        // 置換が行われたかチェック
                        if ($new_p_content !== $p_content) {
                            $p_content = $new_p_content;
                            $link_count++;
                        }
                    }
                    
                    // 既存のリンクを復元
                    foreach ($existing_links as $placeholder => $original_link) {
                        $p_content = str_replace($placeholder, $original_link, $p_content);
                    }
                    
                    return '<p' . (preg_match('/<p([^>]*)>/', $p_matches[0], $p_attrs) ? $p_attrs[1] : '') . '>' . $p_content . '</p>';
                },
                $section_content
            );
            
            return '<section' . (preg_match('/<section([^>]*)>/', $matches[0], $section_attrs) ? $section_attrs[1] : '') . '>' . $section_content . '</section>';
        },
        $content
    );
    
    return $content;
}

// より包括的なアプローチ - すべてのコンテンツに適用
function apply_auto_link_to_all_content($content) {
    // 既に処理済みの場合はスキップ
    if (strpos($content, 'auto-link-keyword') !== false) {
        return $content;
    }
    
    return auto_link_keywords_with_settings($content);
}

// 様々なフックに追加
add_filter('the_content', 'apply_auto_link_to_all_content', 15);
add_filter('the_excerpt', 'apply_auto_link_to_all_content', 15);
add_filter('widget_text', 'apply_auto_link_to_all_content', 15);
add_filter('comment_text', 'apply_auto_link_to_all_content', 15);

// 新しい信頼性の高い関数も追加
add_filter('the_content', 'reliable_auto_link_keywords', 20);

// キーワード自動リンク機能のデバッグ用
function debug_keyword_auto_link() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    if (isset($_GET['debug_keywords']) && $_GET['debug_keywords'] === '1') {
        $keywords = get_cached_keywords();
        echo '<div style="background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;">';
        echo '<h3>キーワード自動リンク デバッグ情報</h3>';
        echo '<p><strong>登録済みキーワード数:</strong> ' . count($keywords) . '</p>';
        echo '<p><strong>機能有効化:</strong> ' . (get_option('keyword_auto_link_enabled', 1) ? '有効' : '無効') . '</p>';
        echo '<p><strong>対象投稿タイプ:</strong> ' . implode(', ', get_option('keyword_auto_link_post_types', array('post', 'page', 'blog', 'glossary'))) . '</p>';
        echo '<p><strong>最大リンク数:</strong> ' . get_option('keyword_auto_link_max_per_post', 10) . '</p>';
        echo '<p><strong>現在のページタイプ:</strong> ' . (is_singular() ? 'singular' : 'not singular') . '</p>';
        echo '<p><strong>現在の投稿タイプ:</strong> ' . get_post_type() . '</p>';
        echo '<p><strong>管理画面かどうか:</strong> ' . (is_admin() ? 'はい' : 'いいえ') . '</p>';
        echo '<p><strong>現在のURL:</strong> ' . $_SERVER['REQUEST_URI'] . '</p>';
        
        if (!empty($keywords)) {
            echo '<h4>登録済みキーワード:</h4>';
            echo '<ul>';
            foreach ($keywords as $keyword => $data) {
                echo '<li><strong>' . esc_html($keyword) . '</strong> → <a href="' . esc_url($data['url']) . '" target="_blank">' . esc_html($data['url']) . '</a>';
                
                if (!empty($data['exclude_pages'])) {
                    echo '<br><span style="color: #d63638; font-size: 0.9em;">除外ページ: ' . esc_html(implode(', ', $data['exclude_pages'])) . '</span>';
                }
                
                echo '</li>';
            }
            echo '</ul>';
        }
        
        // テスト用のコンテンツでキーワード置換をテスト
        if (!empty($keywords)) {
            echo '<h4>テスト置換:</h4>';
            $test_content = 'これはテスト用のコンテンツです。';
            foreach (array_keys($keywords) as $keyword) {
                $test_content .= ' ' . $keyword . ' というキーワードが含まれています。';
            }
            echo '<p><strong>元のコンテンツ:</strong> ' . esc_html($test_content) . '</p>';
            
            // 3つの関数をテスト
            $processed_content1 = auto_link_keywords_with_settings($test_content);
            $processed_content2 = simple_keyword_replace($test_content);
            $processed_content3 = reliable_auto_link_keywords($test_content);
            
            echo '<p><strong>auto_link_keywords_with_settings結果:</strong> ' . $processed_content1 . '</p>';
            echo '<p><strong>simple_keyword_replace結果:</strong> ' . $processed_content2 . '</p>';
            echo '<p><strong>reliable_auto_link_keywords結果:</strong> ' . $processed_content3 . '</p>';
            
            // 実際の投稿コンテンツもテスト
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    $actual_content = get_the_content();
                    if (!empty($actual_content)) {
                        echo '<h4>実際の投稿コンテンツテスト:</h4>';
                        echo '<p><strong>元のコンテンツ（最初の100文字）:</strong> ' . esc_html(substr($actual_content, 0, 100)) . '...</p>';
                        
                        $processed_actual1 = auto_link_keywords_with_settings($actual_content);
                        $processed_actual2 = simple_keyword_replace($actual_content);
                        $processed_actual3 = reliable_auto_link_keywords($actual_content);
                        
                        echo '<p><strong>auto_link_keywords_with_settings結果（最初の100文字）:</strong> ' . substr($processed_actual1, 0, 100) . '...</p>';
                        echo '<p><strong>simple_keyword_replace結果（最初の100文字）:</strong> ' . substr($processed_actual2, 0, 100) . '...</p>';
                        echo '<p><strong>reliable_auto_link_keywords結果（最初の100文字）:</strong> ' . substr($processed_actual3, 0, 100) . '...</p>';
                        
                        // キーワードが含まれているかチェック
                        $found_keywords = array();
                        foreach (array_keys($keywords) as $keyword) {
                            if (stripos($actual_content, $keyword) !== false) {
                                $found_keywords[] = $keyword;
                            }
                        }
                        if (!empty($found_keywords)) {
                            echo '<p><strong>投稿内で見つかったキーワード:</strong> ' . implode(', ', $found_keywords) . '</p>';
                        } else {
                            echo '<p><strong>投稿内にキーワードが見つかりませんでした。</strong></p>';
                        }
                    }
                    break; // 最初の投稿のみ
                }
                rewind_posts();
            }
        }
        
        echo '</div>';
    }
}
add_action('wp_footer', 'debug_keyword_auto_link');

// キーワード除外ページ入力フィールド
function keyword_exclude_pages_callback($post) {
    wp_nonce_field('keyword_exclude_pages_nonce', 'keyword_exclude_pages_nonce');
    $exclude_pages = get_post_meta($post->ID, '_keyword_exclude_pages', true);
    
    if (!is_array($exclude_pages)) {
        $exclude_pages = array();
    }
    
    // 現在のサイトURLを取得
    $site_url = get_site_url();
    ?>
    <p>
        <label for="keyword_exclude_pages">除外するページのURL:</label><br>
        <textarea id="keyword_exclude_pages" name="keyword_exclude_pages" style="width: 100%; height: 100px;" placeholder="1行に1つのURLを入力してください&#10;例:&#10;/about/&#10;/contact/&#10;https://example.com/page"><?php echo esc_textarea(implode("\n", $exclude_pages)); ?></textarea>
        <p class="description">
            <strong>除外ページ設定:</strong> このキーワードの自動リンク化を無効にするページのURLを入力してください。<br>
            <strong>サイト内ページ:</strong> 相対パスを入力してください（例: /about/, /contact/）<br>
            <strong>外部ページ:</strong> 完全なURLを入力してください（例: https://example.com/page）<br>
            <strong>複数ページ:</strong> 1行に1つのURLを入力してください
        </p>
        <p class="description">
            <strong>現在のサイトURL:</strong> <?php echo esc_html($site_url); ?>
        </p>
    </p>
    <?php
}

/**
 * 用語集の投稿を五十音順に並び替え
 */
function sort_glossary_posts_by_gojuon($query) {
    // 管理画面では実行しない
    if (is_admin()) {
        return;
    }
    
    // 用語集のアーカイブページまたはカテゴリーページの場合のみ
    if (is_post_type_archive('glossary') || is_tax('glossary_category')) {
        // メインクエリの場合のみ
        if ($query->is_main_query()) {
            // 五十音順でソート
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
            
            // ページネーションを有効にする
            $query->set('posts_per_page', get_option('posts_per_page', 10));
        }
    }
}
add_action('pre_get_posts', 'sort_glossary_posts_by_gojuon');

/**
 * 用語集の投稿を日本語の五十音順でソートするカスタム関数
 */
function sort_glossary_posts_gojuon($posts) {
    if (empty($posts)) {
        return $posts;
    }
    
    // 五十音順の配列を定義
    $gojuon = array(
        'あ', 'い', 'う', 'え', 'お',
        'か', 'き', 'く', 'け', 'こ',
        'さ', 'し', 'す', 'せ', 'そ',
        'た', 'ち', 'つ', 'て', 'と',
        'な', 'に', 'ぬ', 'ね', 'の',
        'は', 'ひ', 'ふ', 'へ', 'ほ',
        'ま', 'み', 'む', 'め', 'も',
        'や', 'ゆ', 'よ',
        'ら', 'り', 'る', 'れ', 'ろ',
        'わ', 'を', 'ん',
        'が', 'ぎ', 'ぐ', 'げ', 'ご',
        'ざ', 'じ', 'ず', 'ぜ', 'ぞ',
        'だ', 'ぢ', 'づ', 'で', 'ど',
        'ば', 'び', 'ぶ', 'べ', 'ぼ',
        'ぱ', 'ぴ', 'ぷ', 'ぺ', 'ぽ',
        'きゃ', 'きゅ', 'きょ',
        'しゃ', 'しゅ', 'しょ',
        'ちゃ', 'ちゅ', 'ちょ',
        'にゃ', 'にゅ', 'にょ',
        'ひゃ', 'ひゅ', 'ひょ',
        'みゃ', 'みゅ', 'みょ',
        'りゃ', 'りゅ', 'りょ',
        'ぎゃ', 'ぎゅ', 'ぎょ',
        'じゃ', 'じゅ', 'じょ',
        'びゃ', 'びゅ', 'びょ',
        'ぴゃ', 'ぴゅ', 'ぴょ'
    );
    
    // ソート用の比較関数
    usort($posts, function($a, $b) use ($gojuon) {
        $title_a = mb_strtolower($a->post_title, 'UTF-8');
        $title_b = mb_strtolower($b->post_title, 'UTF-8');
        
        // 最初の文字を取得
        $first_char_a = mb_substr($title_a, 0, 1, 'UTF-8');
        $first_char_b = mb_substr($title_b, 0, 1, 'UTF-8');
        
        // 五十音順のインデックスを取得
        $index_a = array_search($first_char_a, $gojuon);
        $index_b = array_search($first_char_b, $gojuon);
        
        // 五十音順に含まれない文字の場合は最後に配置
        if ($index_a === false) $index_a = 999;
        if ($index_b === false) $index_b = 999;
        
        // 五十音順で比較
        if ($index_a !== $index_b) {
            return $index_a - $index_b;
        }
        
        // 同じ五十音の場合は文字列全体で比較
        return strcmp($title_a, $title_b);
    });
    
    return $posts;
}

/**
 * 用語集のクエリ結果を五十音順にソート
 */
function sort_glossary_query_results($query) {
    // 管理画面では実行しない
    if (is_admin()) {
        return;
    }
    
    // 用語集のアーカイブページまたはカテゴリーページの場合のみ
    if (is_post_type_archive('glossary') || is_tax('glossary_category')) {
        // メインクエリの場合のみ
        if ($query->is_main_query()) {
            add_filter('the_posts', 'sort_glossary_posts_gojuon');
        }
    }
}
add_action('pre_get_posts', 'sort_glossary_query_results');


