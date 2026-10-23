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

  <div class="about-statement">

  <section class="content-block content-block-philosophy">
    <h2 class="content-title">(PHILOSOPHY)</h2>
    <h3 class="content-heading">テクノロジーで、社会に新しい余白を。</h3>
    <div class="content-text">
      <p>テクノロジーは、人の可能性を広げるためにある。</p>
      <p>私たちはAIをはじめとする技術を活用し、業務の効率化や仕組み化を進めることで、人と企業に新しい「余白」を生み出します。</p>
      <p>そして、その余白が新しい挑戦や創造につながる社会をつくります。</p>
    </div>
  </section>

  <section class="content-block content-block-vision">
    <h2 class="content-title">(VISION)</h2>
    <h3 class="content-heading">生まれた余白を、挑戦へ。</h3>
    <div class="content-text">
      <p>効率化によって生まれた時間や余力を、ただの余白で終わらせない。</p>
      <p>新しい事業、新しい働き方、新しいアイデア。</p>
      <p>その余白を、人や企業が次の一歩を踏み出すための挑戦へ変えていきます。</p>
    </div>
  </section>

  <section class="content-block content-block-mission">
    <h2 class="content-title">(MISSION)</h2>
    <h3 class="content-heading">AIと人の共創で、<br>余白を挑戦へ、挑戦を価値へ変える。</h3>
    <div class="content-text">
      <p>AIには、業務を効率化し、仕組みを変える力があります。</p>
      <p>人には、考え、創造し、挑戦する力があります。</p>
      <p>私たちはAIと人、それぞれの強みを活かしながら、企業や人の挑戦を実装し、新しい価値へ変えていきます。</p>
    </div>
  </section>

  <section class="content-block content-block-approach">
    <h2 class="content-title">(OUR APPROACH)</h2>
    <h3 class="content-heading">挑戦を、実装する。</h3>
    <ul class="approach-messages">
      <li>事業を理解する。</li>
      <li>技術で実現する。</li>
      <li>人とAIをつなぐ。</li>
      <li>挑戦を価値へ変える。</li>
    </ul>
    <div class="content-text">
      <p>私たちは、開発だけを行う会社でも、事業を考えるだけの会社でもありません。</p>
      <p>経営や事業の目的を理解し、必要な技術を選び、人・組織・業務・AIをつなぎながら、構想を実際に動く仕組みへ変えていきます。</p>
      <p>そして、私たち自身も事業に挑戦し続けます。</p>
      <p>そこで得た経験や知見を、お客様の新しい挑戦へ還元していきます。</p>
    </div>
  </section>

  <section class="content-block content-block-values">
    <h2 class="content-title">(VALUES)</h2>
    <h3 class="content-heading">「&amp;」から、価値をつくる。</h3>
    <ul class="values-list">
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Think Beyond</span></p>
        <p class="values-text">常識の外側から考える。</p>
      </li>
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Embrace AI</span></p>
        <p class="values-text">AIを前提に考える。</p>
      </li>
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Challenge First</span></p>
        <p class="values-text">まず挑戦する。</p>
      </li>
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Build Together</span></p>
        <p class="values-text">一緒につくる。</p>
      </li>
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Be Honest</span></p>
        <p class="values-text">誠実である。</p>
      </li>
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Create Impact</span></p>
        <p class="values-text">価値を生み出す。</p>
      </li>
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Human First</span></p>
        <p class="values-text">人を中心に考える。</p>
      </li>
      <li class="values-item">
        <p class="values-name">&amp; <span class="values-name-en">Grow Together</span></p>
        <p class="values-text">仲間と成長する。</p>
      </li>
    </ul>
  </section>

  <section class="content-block content-block-cycle">
    <h2 class="content-title">(&amp;BLD VALUE CYCLE)</h2>
    <h3 class="content-heading">余白から、次の挑戦へ。</h3>
    <div class="value-cycle-image">
      <img
        src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/andbld-value-cycle-icons.png' ); ?>"
        alt="アンドビルドの価値創出サイクル。余白から挑戦が生まれ、価値創出、成長を経て新しい余白につながる。"
        loading="lazy"
        decoding="async"
      >
    </div>
    <div class="content-text">
      <p>テクノロジーによって余白を生み、その余白を新しい挑戦へ。</p>
      <p>挑戦から価値を生み、成長へつなげる。</p>
      <p>そして、その成長がまた新しい余白を生み出す。</p>
      <p>私たちは、この循環を社会に広げていきます。</p>
    </div>
  </section>

  </div>

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
          <td>AI・Webシステム開発、業務自動化、IT・AIコンサルティング、新規事業支援、自社事業の企画・運営</td>
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