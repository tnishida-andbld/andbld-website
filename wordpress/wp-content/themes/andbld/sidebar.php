<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package andbld
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>

	<section class="widget widget-area-glossary">
    <div class="widget-glossary-inner">
      <h2 class="wp-block-heading">用語解説</h2>
      <div class="widget-glossary-wrapper">
        <div class="widget-glossary-list">
          <h3 class="widget-glossary-title">五十音で探す</h3>
          <div class="widget-glossary-list-inner widget-glossary-list-inner-kana">
            <ul>
              <li><a href="<?php echo home_url('/glossary-category/gros-a-o/'); ?>">あ</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-ka-ko/'); ?>">か</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-sa-so/'); ?>">さ</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-ta-to/'); ?>">た</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-na-no/'); ?>">な</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-ha-ho/'); ?>">は</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-ma-mo/'); ?>">ま</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-ya-yo/'); ?>">や</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-ra-ro/'); ?>">ら</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-wa-n/'); ?>">わ</a></li>
            </ul>
          </div>
        </div>
        <div class="widget-glossary-list">
          <h3 class="widget-glossary-title">アルファベットで探す</h3>
          <div class="widget-glossary-list-inner widget-glossary-list-inner-alpha">
            <ul>
              <li><a href="<?php echo home_url('/glossary-category/gros-a/'); ?>">A</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-b/'); ?>">B</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-c/'); ?>">C</a></li> 
              <li><a href="<?php echo home_url('/glossary-category/gros-d/'); ?>">D</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-e/'); ?>">E</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-f/'); ?>">F</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-g/'); ?>">G</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-h/'); ?>">H</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-i/'); ?>">I</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-j/'); ?>">J</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-k/'); ?>">K</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-l/'); ?>">L</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-m/'); ?>">M</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-n/'); ?>">N</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-o/'); ?>">O</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-p/'); ?>">P</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-q/'); ?>">Q</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-r/'); ?>">R</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-s/'); ?>">S</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-t/'); ?>">T</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-u/'); ?>">U</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-v/'); ?>">V</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-w/'); ?>">W</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-x/'); ?>">X</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-y/'); ?>">Y</a></li>
              <li><a href="<?php echo home_url('/glossary-category/gros-z/'); ?>">Z</a></li>
            </ul>
          </div>
        </div>
        <div class="widget-glossary-list">
          <h3 class="widget-glossary-title">数字で探す</h3>
          <div class="widget-glossary-list-inner widget-glossary-list-inner-num">
            <ul>
              <li><a href="<?php echo home_url('/glossary-category/gros-0-9/'); ?>">0～9</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

</aside><!-- #secondary -->
