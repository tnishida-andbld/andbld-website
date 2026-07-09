<?php
/**
 * About page template part
 *
 * @package andbld
 */

$page = get_post( get_the_ID() );
$slug = $page->post_name;

?>
<div class="<?php echo $slug; ?>-content">

  <section class="content-block content-block-philosophy">
    <h2 class="content-title">(PHILOSOPHY)</h2>
    <div class="content-text">
      <p>テクノロジーで、社会に新しい余白を</p>
      <!-- <p class="sub-philosophy-text">クライアント、従業員、そして社会と「共に創る」企業であり続ける</p> -->
    </div>
  </section>

  <section class="content-block content-block-vision">
    <h2 class="content-title">(VISION)</h2>
    <div class="content-text">
      <p>私たちはAIとRPAを活用して業務を革新し、生産性と効率を高めることで、人々の時間と心に新たな余白を生み出します。</p>
      <p>その余白を未来を切り拓く挑戦や創造的な活動へとつなげ、経済的にも時間的にも豊かで、持続可能な社会の実現を目指しています。</p>
    </div>
  </section>

  <section class="content-block content-block-mission">
    <h2 class="content-title">(MISSION)</h2>
    <div class="content-text">
      <p>■ 私たちの技術によって日本の労働生産性を高め、人口減少時代における経済の停滞を改善します。<br>業務の自動化を通じて、人々に経済的・時間的な豊かさをもたらし、持続可能で豊かな社会の実現を目指します。</p>
      <p>■ 私たちは企業の業務をAI×RPAで自動化し、人材が重要かつ創造的な業務に集中できる環境を実現します。<br>
			“8割の業務をAIで”という変革を可能にし、属人的な組織からの脱却と人材不足の解消を支援します。</p>
      <p>■ 私たちは時間や場所にとらわれない柔軟な働き方を提供し、経済的な豊かさと働く意欲を高める環境を実現します。<br>
			さらに、高品質な育成プログラムを通じて次世代のAI×RPA人材を育成し、その力を社会へ循環させることで、持続的な価値創造につなげます。</p>
    </div>
  </section>

  <section class="content-block content-block-outline">
    <h2 class="content-title">(OUTLINE)</h2>
    <div class="content-table">
      <table class="table-outline">
        <tr>
          <th>会社名</th>
          <td>アンドビルド株式会社</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>〒104-0061 東京都中央区銀座1丁目22-11 銀座大竹ビジデンス2階</td>
        </tr>
        <tr>
          <th>設立</th>
          <td>2021年10月</td>
        </tr>
        <tr>
          <th>代表者</th>
          <td>代表取締役　西田 達也</td>
        </tr>
        <tr>
          <th>資本金</th>
          <td>6,000,000円</td>
        </tr>
        <tr>
          <th>事業内容</th>
          <td>業務効率化支援事業（AI×RPAおよびWEB-SI統合開発・コンサルティング・インフラコスト削減）</td>
        </tr>
        <tr>
          <th>提供サービス</th>
          <td>
            <ul>
              <li>BizScan「業務プロセス分析と自動化適性診断」</li>
              <li>CreativeForce「ソリューション設計・導入」</li>
              <li>NextGen .Lab「AI×RPA人材の育成プログラム」</li>
              <li>Guardian「運用・保守サポート」</li>
            </ul>
          </td>
        </tr>
		<!--
        <tr>
          <th>所属団体</th>
          <td>
            <ul>
              <li>一般社団法人 生成AI活用普及協会（GUGA）</li>
            </ul>
          </td>
        </tr>
		-->
      </table>
    </div>
  </section>

  <section class="content-block content-block-access">
    <h2 class="content-title">(ACCESS)</h2>
    <div class="content-textarea">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d810.3027655072353!2d139.7702503696228!3d35.67180468776114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188be1ad50de4d%3A0x1347d6538522f670!2z44CSMTA0LTAwNjEg5p2x5Lqs6YO95Lit5aSu5Yy66YqA5bqn77yR5LiB55uuMeKIku-8ku-8kuKIku-8ke-8kQ!5e0!3m2!1sja!2sjp!4v1749112579441!5m2!1sja!2sjp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>

</div>