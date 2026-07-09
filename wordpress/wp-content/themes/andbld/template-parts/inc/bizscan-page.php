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
    <h2 class="content-title">独自の経験とナレッジを活かした課題発見力で、変革を。<br>隠れた非効率を見つけ出す</h2>
    <div class="content-text">
      <p>業務分析から自動化提案まで。あなたの会社の隠れた課題を発見します</p>
    </div>
  </section>

  <section class="content-block content-block-assignment">
    <h2 class="content-title">こんな課題を抱えていませんか？</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li>
          <div class="icon"><i class="bi bi-clock"></i></div>
          <h2>定型業務に時間を取られる</h2>
          <p>毎日同じような作業の繰り返しで、創造的な業務に時間を割けない</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-person-fill-dash"></i></div>
          <h2>人材不足で業務が回らない</h2>
          <p>人手不足で業務効率化が急務だが、何から手をつけていいかわからない</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-question-circle"></i></div>
          <h2>自動化できる業務がわからない</h2>
          <p>AI×RPAに興味はあるが、自社のどの業務が自動化できるか判断できない</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-cash-coin"></i></div>
          <h2>投資効果が見えない</h2>
          <p>システム導入にかかるコストと効果が不明で、投資判断ができない</p>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-settlement">
    <h2 class="content-title">BizScanが解決します</h2>
    <div class="content-text">
      <p>BizScanは、あなたの会社の業務を徹底的に分析し、AI×RPA自動化の最適解を科学的に導き出す診断サービスです。 人材教育とWEB開発の豊富な経験から培った独自の課題発見力で、隠れた非効率を見つけ出します。</p>
      <ul class="services-content-block">
        <li>
          <div class="icon"><i class="bi bi-clipboard-data"></i></div>
          <h2>科学的な診断</h2>
          <p>4つの評価軸で100点満点の客観的評価。感覚ではなくデータで判断</p>
        </li>
        <li>
          <div class="icon"><i class="bi bi-lightbulb-fill"></i></div>
          <h2>ROI明確化</h2>
          <p>投資額・削減効果・回収期間を具体的な数値で算出。安心の投資判断</p>
        </li>
        <li>
          <div class="icon"><i class="bi bi-check-circle"></i></div>
          <h2>すぐに実行可能</h2>
          <p>1週間で完了。診断結果をもとに即座に次のステップへ進むことが可能</p>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-process">
    <h2 class="content-title">実施プロセス</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li>
          <div class="num">01</div>
          <div class="process-content">
            <h2>キックオフ・現状ヒアリング</h2>
            <p>プロジェクト目標の確認と集中ヒアリング（8時間）。分析対象業務を1-2プロセスに絞り込み、効率的に進めます。</p>
          </div>
        </li>
        <li>
          <div class="num">02</div>
          <div class="process-content">
            <h2>業務分析・課題特定</h2>
            <p>現状業務フローの作成と自動化適性の科学的評価（16時間）。4つの評価軸で客観的に判定します。</p>
          </div>
        </li>
        <li>
          <div class="num">03</div>
          <div class="process-content">
            <h2>ソリューション設計・ROI算出</h2>
            <p>改善案の策定とROI算出（8時間）。具体的な削減効果と投資回収期間を数値で提示します。</p>
          </div>
        </li>
        <li>
          <div class="num">04</div>
          <div class="process-content">
            <h2>資料完成・プレゼンテーション</h2>
            <p>成果物の最終確認と結果報告（2.2時間）。経営陣向けの分かりやすいプレゼンテーションを実施します。</p>
          </div>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-result">
    <h2 class="content-title">お渡しする成果物</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li class="result-item">
          <h2>現状業務分析レポート</h2>
          <p>10-15ページ</p>
          <ul>
            <li>業務フロー図</li>
            <li>課題・ボトルネック分析</li>
            <li>改善機会の特定</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>自動化適性診断書</h2>
          <p>5-8ページ</p>
          <ul>
            <li>科学的評価結果（100点満点）</li>
            <li>技術的実現可能性</li>
            <li>優先順位マトリックス</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>改善提案書</h2>
          <p>8-12ページ</p>
          <ul>
            <li>具体的改善案</li>
            <li>ROI・効果算出</li>
            <li>導入ステップ</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>ROI算出シート</h2>
          <p>Excel形式</p>
          <ul>
            <li>現状コスト計算</li>
            <li>改善後効果予測</li>
            <li>3年間収益予測</li>
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
          <h2>30万円</h2>
          <p>（税別・1-2業務プロセス対象）</p>
          <ul>
            <li>1週間での迅速診断</li>
            <li>科学的な自動化適性評価</li>
            <li>具体的なROI算出</li>
            <li>23-35ページの詳細レポート</li>
            <li>Excel形式のROI算出シート</li>
            <li>経営陣向けプレゼンテーション</li>
          </ul>
          <div class="option-block">
            <h3>オプション</h3>
            <ul>
              <li>追加業務プロセス分析：+5万円/プロセス</li>
              <li>詳細技術検証：+10万円</li>
              <li>現場説明会：+3万円/回</li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </section>
  */
  ?>

</div>