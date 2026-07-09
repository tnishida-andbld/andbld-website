<?php
/**グローバル変数を定義**/
$dir = get_template_directory();
include($dir. "/custom.php");
?>

<div class="header-wrap header-block1">
	<div class="head-container global-header">
		<div class="row">
			<div class="head-left">
				<div class="site-branding">
					<?php if ( is_home() || is_front_page() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $custom_logo; ?></a></h1>
					<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $custom_logo; ?></a></p>
					<?php endif; ?>
				</div><!-- .site-branding -->
			</div>
			<?php
			// /contact/ページでは非表示にする
			if ( !is_page('contact') ) :
			?>
			<div class="nav-right">
				<div class="nav-container">
					<nav id="site-navigation" class="main-navigation">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
						<div class="main-menucontainer">
							<?php
								wp_nav_menu(
								array(
									'theme_location'=>'main-menu',
									'container' => false,
									'menu_class' => 'nav',
									'link_before' => '<div>',
									'link_after' => '</div>',
									'items_wrap' => '<ul>%3$s</ul>',
									)
								);
							?>
						</div>
					</nav><!-- #site-navigation -->
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div><!-- header-wrap -->