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

  <div class="services-statement">

  <section class="content-block content-block-introduction">
    <h2 class="content-heading">事業を前に進めるために、必要な方法を。</h2>
    <div class="content-text">
      <p>私たちは、技術を導入すること自体を目的にはしません。</p>
      <p>事業や経営の課題を理解し、その実現に必要なAI、Webシステム、業務自動化、コンサルティングなどを組み合わせ、構想から実装、運用・改善まで伴走します。</p>
    </div>
  </section>

  <section class="content-block content-block-areas">
    <ul class="service-card-list">
      <li class="service-card">
        <div class="title-wrap">
          <h2>TECHNOLOGY</h2>
          <p>技術領域</p>
        </div>
        <p class="catch-wrap">事業の挑戦を、確かな技術で実装する。</p>
        <ul class="service-card-points">
          <li>
            <p class="service-card-name">AI開発・導入支援</p>
            <p class="service-card-desc">AIを、実際の業務で使える仕組みへ。</p>
          </li>
          <li>
            <p class="service-card-name">Webシステム開発</p>
            <p class="service-card-desc">事業を支える、Webの仕組みをつくる。</p>
          </li>
          <li>
            <p class="service-card-name">RPA・業務自動化</p>
            <p class="service-card-desc">繰り返す仕事を、仕組みに変える。</p>
          </li>
          <li>
            <p class="service-card-name">AIエージェント開発</p>
            <p class="service-card-desc">AIが考え、動く業務環境へ。</p>
          </li>
          <li>
            <p class="service-card-name">CMS構築</p>
            <p class="service-card-desc">更新しやすく、成長できるWeb基盤を。</p>
          </li>
          <li>
            <p class="service-card-name">API・システム連携</p>
            <p class="service-card-desc">分かれたシステムとデータを、つなぐ。</p>
          </li>
          <li>
            <p class="service-card-name">保守・運用支援</p>
            <p class="service-card-desc">つくった後も、育て続ける。</p>
          </li>
        </ul>
        <div class="btn-wrap">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-link">お問い合わせ</a>
        </div>
      </li>
      <li class="service-card">
        <div class="title-wrap">
          <h2>BUSINESS</h2>
          <p>事業領域</p>
        </div>
        <p class="catch-wrap">事業の構想から成長まで、実践知で伴走する。</p>
        <ul class="service-card-points">
          <li>
            <p class="service-card-name">IT・AIコンサルティング</p>
            <p class="service-card-desc">経営・事業課題を整理し、ITやAIの活用方針から実行計画まで一貫して支援します。</p>
          </li>
          <li>
            <p class="service-card-name">DX推進支援</p>
            <p class="service-card-desc">業務や組織の現状を可視化し、デジタル技術を活用した変革の推進を支援します。</p>
          </li>
          <li>
            <p class="service-card-name">AI活用戦略</p>
            <p class="service-card-desc">AIの導入を目的とせず、事業成果につながる活用領域の選定と実行を支援します。</p>
          </li>
          <li>
            <p class="service-card-name">新規事業支援</p>
            <p class="service-card-desc">事業アイデアの具体化からサービス設計・立ち上げまで、実践的な視点で伴走します。</p>
          </li>
        </ul>
        <div class="btn-wrap">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-link">お問い合わせ</a>
        </div>
      </li>
    </ul>
  </section>

  <section class="content-block content-block-owned">
    <h2 class="content-title">(OUR BUSINESS)</h2>
    <h3 class="content-heading">私たち自身も、挑戦し続ける。</h3>
    <div class="content-text">
      <p>私たちは、技術や事業づくりを支援するだけでなく、自らも新しい事業に挑戦しています。</p>
      <p>自社事業で得た経験や学びを、次の価値創出につなげています。</p>
    </div>
    <ul class="owned-list">
      <li class="owned-card">
        <p class="owned-num">01</p>
        <p class="owned-name">EC事業</p>
        <p class="owned-text">商品の仕入れ・販売からECサイトやマーケットプレイスでの運営まで、自社で実践しています。</p>
      </li>
      <li class="owned-card">
        <p class="owned-num">02</p>
        <p class="owned-name">海外事業</p>
        <p class="owned-text">海外の企業やパートナーとの連携を通じて、新たな市場や事業機会の創出に取り組んでいます。</p>
      </li>
      <li class="owned-card">
        <p class="owned-num">03</p>
        <p class="owned-name">商品開発</p>
        <p class="owned-text">市場のニーズや事業機会を捉え、企画から商品化・販売まで一貫した事業づくりに挑戦しています。</p>
      </li>
    </ul>
  </section>

  <section class="content-block content-block-approach-flow">
    <h2 class="content-title">(OUR APPROACH)</h2>
    <h3 class="content-heading">技術からではなく、事業から考える。</h3>
    <div class="content-text">
      <p>「AIを導入したい」「システムをつくりたい」から始めるのではなく、その先で何を実現したいのかを考える。</p>
      <p>事業や業務を理解したうえで、必要な技術と方法を選び、実装し、現場で使われる仕組みへ育てていきます。</p>
    </div>
    <ul class="approach-flow">
      <li class="approach-step">
        <div class="approach-num">01</div>
        <div class="approach-body">
          <p class="approach-name">事業を理解する</p>
          <p class="approach-desc">事業の目的や目指す姿を共有し、現状の業務や取り組みを理解します。</p>
        </div>
      </li>
      <li class="approach-step">
        <div class="approach-num">02</div>
        <div class="approach-body">
          <p class="approach-name">課題を整理する</p>
          <p class="approach-desc">現状と目標の間にある課題を明確にし、取り組むべきことを整理します。</p>
        </div>
      </li>
      <li class="approach-step">
        <div class="approach-num">03</div>
        <div class="approach-body">
          <p class="approach-name">必要な方法を考える</p>
          <p class="approach-desc">AI・Webシステム・業務自動化などから、課題に適した方法を検討します。</p>
        </div>
      </li>
      <li class="approach-step">
        <div class="approach-num">04</div>
        <div class="approach-body">
          <p class="approach-name">設計・実装する</p>
          <p class="approach-desc">選定した方法を具体的な仕組みに落とし込み、設計・開発・実装します。</p>
        </div>
      </li>
      <li class="approach-step">
        <div class="approach-num">05</div>
        <div class="approach-body">
          <p class="approach-name">運用・改善する</p>
          <p class="approach-desc">導入後も活用状況を確認し、改善を重ねながら現場に定着させます。</p>
        </div>
      </li>
    </ul>
  </section>

  </div>

</div>
