<?php
/**
 * Careers page template part
 *
 * @package andbld
 */

$page = get_post( get_the_ID() );
$slug = $page->post_name;

?>
<div class="<?php echo $slug; ?>-content">
    <section class="content-block content-block-careers">
        <div class="content-text">
            <p>現在、募集情報はございません。</p>
        </div>
    </section>
</div> 