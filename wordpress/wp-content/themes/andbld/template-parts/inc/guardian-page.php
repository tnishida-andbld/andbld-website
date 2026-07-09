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
    <h2 class="content-title">安心の運用サポート体制を提供。<br>継続的な改善提案でさらなる効率化を実現</h2>
    <div class="content-text">
      <p>CreativeForceで導入したAI×RPAシステムの安定運用と継続的改善をサポート</p>
    </div>
  </section>

  <section class="content-block content-block-assignment">
    <h2 class="content-title">システム導入後の課題</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li>
          <div class="icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
          <h2>システムが突然止まる</h2>
          <p>運用開始後にエラーが発生しても、対応方法がわからず業務が停止してしまう</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-graph-down-arrow"></i></div>
          <h2>効果が徐々に低下</h2>
          <p>導入当初は効果があったが、時間とともに効率化効果が薄れている</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-question-circle-fill"></i></div>
          <h2>改善方法がわからない</h2>
          <p>もっと自動化できそうな業務があるが、どう改善すべきかわからない</p>
        </li>
        <li class="services-content-block">
          <div class="icon"><i class="bi bi-person-fill-gear"></i></div>
          <h2>専門人材がいない</h2>
          <p>社内にシステム運用・保守の専門知識を持った人材がいない</p>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-settlement">
    <h2 class="content-title">Guardianが解決します</h2>
    <div class="content-text">
      <p>Guardianは、CreativeForceで導入したAI×RPAシステムの安定運用を支援し、 継続的な監視・改善提案により、システムの価値を最大化し続けるマネージドサービスです。 24時間365日の監視体制で、あなたのビジネスを守ります。</p>
      <ul class="services-content-block">
        <li>
          <div class="icon"><i class="bi bi-clock-fill"></i></div>
          <h2>24時間監視</h2>
          <p>システムの稼働状況を常時監視。障害の早期発見・迅速対応で安定稼働を保証</p>
        </li>
        <li>
          <div class="icon"><i class="bi bi-graph-up-arrow"></i></div>
          <h2>継続的改善</h2>
          <p>データ分析に基づく改善提案。ROI効果測定と新たな自動化機会の発見</p>
        </li>
        <li>
          <div class="icon"><i class="bi bi-people-fill"></i></div>
          <h2>専門サポート</h2>
          <p>AI×RPA専門チームによる手厚いサポート。技術的な課題も迅速に解決</p>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-result">
    <h2 class="content-title">提供サービス</h2>
    <div class="content-text">
      <ul class="services-content-block">
        <li class="result-item">
          <h2>運用監視・保守</h2>
          <ul>
            <li>システム稼働状況の24時間監視</li>
            <li>エラー・障害の早期発見・対応</li>
            <li>定期メンテナンス・最適化</li>
            <li>バックアップ・復旧サポート</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>効果測定・分析</h2>
          <ul>
            <li>ROI実績の定量測定</li>
            <li>システム利用状況の詳細分析</li>
            <li>月次・四半期レポート作成</li>
            <li>KPI達成状況の評価</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>改善提案・実装</h2>
          <ul>
            <li>データに基づく改善案策定</li>
            <li>新機能・拡張の提案</li>
            <li>隣接業務の自動化機会発見</li>
            <li>技術トレンド対応</li>
          </ul>
        </li>
        <li class="result-item">
          <h2>ユーザーサポート</h2>
          <ul>
            <li>専用ヘルプデスク対応</li>
            <li>操作方法・トラブル解決</li>
            <li>定期研修・ベストプラクティス共有</li>
            <li>FAQ・マニュアル更新</li>
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
          <p class="price-title">ライト</p>
          <h2><span>月額</span>10<span>万円</span></h2>
          <p>スタンダードパッケージ導入企業向け</p>
          <ul>
            <li>基本監視・稼働状況確認</li>
            <li>月次レポート提供</li>
            <li>緊急時対応（平日9-18時）</li>
            <li>軽微な設定変更（月1回まで）</li>
            <li>稼働率95%以上保証</li>
          </ul>
        </li>
        <li class="price-item">
          <p class="price-title">スタンダード</p>
          <h2><span>月額</span>20<span>万円～</span></h2>
          <p>プロフェッショナルパッケージ導入企業向け</p>
          <ul>
            <li>詳細監視・パフォーマンス分析</li>
            <li>月次改善提案・レポート</li> 
            <li>緊急時対応（平日9-21時）</li>
            <li>軽微な機能追加・変更（月2回まで）</li>
            <li>四半期レビューミーティング</li>
            <li>稼働率98%以上保証</li>
          </ul>
        </li>
        <li class="price-item">
          <p class="price-title">プレミアム</p>
          <h2><span>月額</span>35<span>万円～</span></h2>
          <p>エンタープライズパッケージ導入企業向け</p>
          <ul>
            <li>24時間監視・即座の障害対応</li>
            <li>詳細な効果測定・改善提案</li>
            <li>新機能開発・追加（年2回まで）</li>
            <li>月次レビューミーティング</li>
            <li>専用サポート窓口</li>
            <li>稼働率99.5%以上保証</li>
          </ul>
        </li>
      </ul>
    </div>
  </section>

  <section class="content-block content-block-sla">
    <h2 class="content-title">サービスレベル保証（SLA）</h2>
    <div class="content-text">
      <table>
        <tr class="sla-title">
          <th>項目</th>
          <th>ライト</th>
          <th>スタンダード</th>
          <th>プレミアム</th>
        </tr>
        <tr>
          <th>稼働率保証</th>
          <td>95%以上</td>
          <td>98%以上</td>
          <td>99.5%以上</td>
        </tr>
        <tr>
          <th>対応時間</th>
          <td>平日 9:00-18:00</td>
          <td>平日 9:00-21:00</td>
          <td>24時間365日</td>
        </tr>
        <tr>
          <th>軽微障害対応</th>
          <td>1営業日以内</td>
          <td>4時間以内</td>
          <td>1時間以内</td>
        </tr>
        <tr>
          <th>中程度障害対応</th>
          <td>4時間以内</td>
          <td>2時間以内</td>
          <td>30分以内</td>
        </tr>
        <tr>
          <th>重大障害対応</th>
          <td>2時間以内</td>
          <td>1時間以内</td>
          <td>15分以内</td>
        </tr>
      </table>
    </div>
  </section>
  */
  ?>

</div>