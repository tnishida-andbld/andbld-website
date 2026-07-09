<?php
/**
 * Service page template part
 *
 * @package andbld
 */

$page = get_post( get_the_ID() );
$slug = $page->post_name;

?>
<div class="<?php echo $slug; ?>-content">
    <section class="content-block content-block-contact">
      <div class="content-form">
        <script src="https://js-na2.hsforms.net/forms/embed/243208017.js" defer></script>
        <div class="hs-form-frame" data-region="na2" data-form-id="64a19dc3-e7f6-4b05-b0a5-750be6a6bd42" data-portal-id="243208017"></div>
      </div>
    </section>
</div> 