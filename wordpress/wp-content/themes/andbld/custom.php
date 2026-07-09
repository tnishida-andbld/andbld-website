<?php
/**グローバル変数を定義**/

global $custom_logo;
global $custom_companyname;
global $custom_tel;
global $custom_reteltime;
global $custom_zip;
global $custom_address;
global $custom_building;
global $custom_access;
global $custom_map;
global $custom_copyright;

/**ロゴパス**/
$custom_logo = '<img src="' . esc_url( get_template_directory_uri() ) . '/img/andbld-logo.svg" alt="アンドビルド株式会社">';

/**会社名**/
$custom_companyname = 'アンドビルド株式会社';

/**電話番号**/
$custom_tel = '03-6684-1429';

/**電話受付時間**/
$custom_reteltime = '10:00～19:00';

/**郵便番号**/
$custom_zip = '〒104-0061';

/**住所**/
$custom_address = '東京都中央区銀座1丁目22番11号';

/**ビル・マンション名**/
$custom_building = '銀座大竹ビジデンス';

/**アクセス情報**/
$custom_access = array('');

/**マップ情報**/
$custom_map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.135880223234!2d139.76631547623106!3d35.67365608038918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188be3e720cbcf%3A0x4f95efd260fcd28d!2z44CSMTA0LTAwNjEg5p2x5Lqs6YO95Lit5aSu5Yy66YqA5bqn77yR5LiB55uu!5e0!3m2!1sja!2sjp!4v1746604413401!5m2!1sja!2sjp" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';

/**コピーライト記載情報**/
$custom_copyright = 'andbld inc.';

?>