<?php
/**
 * About page template part
 *
 * @package andbld
 */

$page = get_post( get_the_ID() );
$slug = $page->post_name;

?>
<div class="<?php echo $slug; ?>-content services-content">

  <section class="content-block content-block-catch">
    <h2 class="content-title">設計から導入まで、完全オーダーメイド。<br>あなた専用のAI×RPA・WEB-SIソリューションを提供</h2>
    <div class="content-text">
      <p>BizScanの診断結果を基に、AI×RPA・WEB-SI統合ソリューションの設計・開発・導入</p>
    </div>
  </section>

  <section class="content-block content-block-assignment">
    <h2 class="content-title">こんな課題を抱えていませんか？</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li>
          <div class="icon"><i class="bi bi-terminal-x"></i></div>
          <h2>どこから始めていいかわからない</h2>
          <p>AI×RPAに興味はあるが、具体的にどのシステムを作ればいいか決められない</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-gear-wide"></i></div>
          <h2>既製品では対応できない</h2>
          <p>パッケージソフトでは自社の業務に合わず、カスタマイズが必要</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-person-fill-x"></i></div>
          <h2>WEBサイト・システムの老朽化</h2>
          <p>既存のWEBサイト・システムが古く、AIや最新技術への対応ができていない</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-exclamation-octagon"></i></div>
          <h2>導入に時間がかかりすぎる</h2>
          <p>他社のシステム開発は期間が長く、すぐに効果を実感できない</p>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-settlement">
    <h2 class="content-title">CreativeForceが解決します</h2>
    <div class="content-text">
      <p>CreativeForceは、BizScanで特定した課題を基に、AI×RPA・WEB-SI統合ソリューションを提供します。 Microsoft Power Platformを活用した業務自動化から、AIを活用したWEBシステム開発まで、 完全オーダーメイドでありながら、効率的な開発手法により短期間・低コストを実現。</p>
      <ul class="services-content-block">
        <li>
          <div class="icon"><i class="bi bi-wrench-adjustable"></i></div>
          <h2>完全オーダーメイド</h2>
          <p>BizScan結果を基に、AI×RPA・WEB-SIを統合したシステムを構築</p>
        </li>
        <li>
          <div class="icon"><i class="bi bi-sort-down"></i></div>
          <h2>短期間・低コスト</h2>
          <p>豊富なWEB開発経験とPower Platform活用により効率的に開発完了</p>
        </li>
        <li>
          <div class="icon"><i class="bi bi-shield-fill-check"></i></div>
          <h2>統合ソリューション</h2>
          <p>WEBシステム・AI・RPAを連携させた包括的なデジタル変革を実現</p>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-process">
    <h2 class="content-title">開発プロセス</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li>
          <div class="num">01</div>
          <div class="process-content">
            <h2>要件定義・アーキテクチャ設計</h2>
            <p>BizScan結果を基にした統合要件定義。AI×RPA・WEB-SI連携を考慮したシステム全体設計を実施。</p>
          </div>
        </li>
        <li>
          <div class="num">02</div>
          <div class="process-content">
            <h2>統合開発・連携構築</h2>
            <p>WEBシステム・AI・RPAの統合開発。Power Platform・モダンWEB技術を活用した効率的な開発を実施。</p>
          </div>
        </li>
        <li>
          <div class="num">03</div>
          <div class="process-content">
            <h2>統合テスト・本格導入</h2>
            <p>システム全体の統合テスト・パフォーマンステスト。段階的導入とユーザー研修で確実な運用開始。</p>
          </div>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-result">
    <h2 class="content-title">業種別特化ソリューション</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li class="result-item">
          <h2>Manufacturing Force</h2>
          <p>製造業向けソリューション</p>
          <ul>
            <li><strong>AI×RPA：</strong>受注処理、在庫管理、顧客管理、売上分析、品質管理の自動化</li>
            <li><strong>WEB-SI：</strong>生産管理WEBシステム・IoTデータ連携</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>Retail Force</h2>
          <p>小売店向けソリューション</p>
          <ul>
            <li><strong>AI×RPA：</strong>受注処理、在庫管理、顧客管理、売上分析、品質管理の自動化</li>
            <li><strong>WEB-SI：</strong>ECサイト・顧客管理WEBシステム構築・IoTデータ連携</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>Finance Force</h2>
          <p>金融業向けソリューション</p>
          <ul>
            <li><strong>AI×RPA：</strong>審査業務、顧客データ管理、コンプライアンス、レポート作成の自動化</li>
            <li><strong>WEB-SI：</strong>顧客ポータル・リスク管理システム・顧客管理WEBシステム構築・IoTデータ連携</li>
          </ul>
        </li>
      </ul>
    </div>
  </section>

  <?php
  /* 料金は表示しない
  <section class="content-block content-block-price">
    <h2 class="content-title">料金</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li class="price-item">
          <p class="price-title">スタンダード</p>
          <h2>250<span>万円～</span></h2>
          <p>期間：1.5ヶ月～</p>
          <ul>
            <li>1-2業務プロセスの自動化</li>
            <li>Power Automate フロー開発（2-3個）</li>
            <li>簡易 Power Apps アプリ（1画面）</li>
            <li>基本的なデータ連携</li>
            <li>テスト・導入支援</li>
            <li>ユーザー研修（2時間）</li>
          </ul>
        </li>
        <li class="price-item">
          <p class="price-title">プロフェッショナル</p>
          <h2>500<span>万円～</span></h2>
          <p>期間：2.5ヶ月～</p>
          <ul>
            <li>3-5業務プロセスの自動化</li>
            <li>Power Automate 複合フロー開発（5-8個）</li> 
            <li>Power Apps アプリ開発（2-3画面）</li>
            <li>AI Builder 活用（OCR・予測モデル）</li>
            <li>既存システム連携（API開発含む）</li>
            <li>SharePoint/OneDrive統合</li>
          </ul>
        </li>
        <li class="price-item">
          <p class="price-title">エンタープライズ</p>
          <h2>1,000<span>万円～</span></h2>
          <p>期間：4ヶ月～</p>
          <ul>
            <li>全社横断・複数部門の大規模自動化</li>
            <li>大規模 Power Platform 環境構築</li>
            <li>カスタムコネクタ開発</li>
            <li>Azure サービス連携</li>
            <li>Azure サービス連携</li>
            <li>段階的ロールアウト</li>
          </ul>
        </li>
      </ul>
    </div>
  </section>
  */
  ?>

</div>