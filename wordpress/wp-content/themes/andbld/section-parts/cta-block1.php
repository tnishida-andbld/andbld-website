<?php
// /contact/ページでは非表示にする
if ( !is_page('contact') ) :
?>
<section class="footer-cta">
	<div class="cta-container footer-cta1">
		<div class="row">
			<h2 class="cta-catch">AI×RPAで業務改革を。<br class="sp-only">まずはお気軽にご相談ください</h2>
			<div class="cta-btn-container">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="cta-btn">お問い合わせ<i class="fas fa-arrow-right"></i></a>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- TOPに戻るボタン -->
<?php
// ブログ部分（/blogs/）または用語集部分（/glossary/）でのみ表示
$show_back_to_top = false;

// ブログ関連ページの判定
if (is_post_type_archive('blog') || 
    is_singular('blog') || 
    is_tax('blog_category') ||
    (is_archive() && get_post_type() === 'blog')) {
    $show_back_to_top = true;
}

// 用語集関連ページの判定
if (is_post_type_archive('glossary') || 
    is_singular('glossary') || 
    is_tax('glossary_category') ||
    is_tax('glossary_tag') ||
    (is_archive() && get_post_type() === 'glossary')) {
    $show_back_to_top = true;
}

// 条件に合致する場合のみボタンを表示
if ($show_back_to_top) :
?>
<div id="back-to-top" class="back-to-top">
	<a href="#top" aria-label="ページトップに戻る">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M12 4L4 12H9V20H15V12H20L12 4Z" fill="currentColor"/>
		</svg>
	</a>
</div>
<?php endif; ?>