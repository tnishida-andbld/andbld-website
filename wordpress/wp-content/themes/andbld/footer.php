<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package andbld
 */

/**グローバル変数を定義**/
$dir = get_template_directory();
include($dir. "/custom.php");

?>

<?php /*cta-block section */
include('section-parts/cta-block1.php');
?>

	<footer id="colophon" class="site-footer">
		<div class="footer-container footer-block1">
			<div class="row">
				<?php
				// /contact/ページでは非表示にする
				if ( !is_page('contact') ) :
				?>
				<div class="footer-menu">
					<ul>
						<li><a href="<?php echo home_url('/privacy-policy'); ?>">個人情報の取扱いについて</a></li>
						<li><a href="<?php echo home_url('/terms'); ?>">サイトご利用にあたって</a></li>
					</ul>
				</div>
				<?php endif; ?>
				<div class="footer-info">
					<div class="footer-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $custom_logo; ?></a>
					</div>
					<p class="footer-copyright">Copyright ©<?php echo date( 'Y' ); ?> <?php echo $custom_copyright; ?> All Rights Reserved.</p>
				</div><!-- .footer-info -->
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
	
</body>
</html>
