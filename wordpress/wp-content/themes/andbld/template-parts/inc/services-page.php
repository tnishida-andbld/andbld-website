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

    <section class="content-block content-block-catch">
        <h2 class="content-title">包括的なAI×RPAソリューション</h2>
        <div class="content-text">
            <p>診断から開発、運用、人材育成まで。あなたのビジネスを変革する4つのサービス</p>
        </div>
    </section>

    <section class="content-block content-block-services">
        <h2 class="content-title">サービス一覧</h2>
        <div class="content-text">
            <ul class="services-content-block">
                <li class="services-content-block-item">
                    <a href="<?php echo home_url('/services/bizscan/'); ?>">
                        <div class="title-wrap">
                            <h2>BizScan</h2>
                            <p>業務診断・課題発見サービス</p>
                        </div>
                        <p class="catch-wrap">独自の経験とナレッジを活かした課題発見力で、変革を</p>
                        <ul class="outline-wrap">
                            <li>科学的な4軸評価による客観的診断</li>
                            <li>具体的なROI算出・投資回収期間提示</li>
                            <li>短期間での迅速な業務分析完了</li>
                            <li>詳細レポート提供</li>
                        </ul>
                        <?php
                        /* 料金は表示しない
                        <div class="price-wrap">
                            <p class="price-text">30<span>万円～</span></p>
                            <p>1-2業務プロセス対象・1週間</p>
                        </div>
                        */
                        ?>
                        <div class="btn-wrap">
                            <a href="<?php echo home_url('/services/bizscan/'); ?>" class="btn-link">詳細を見る</a>
                        </div>
                    </a>
                </li>
                <li class="services-content-block-item">
                    <a href="<?php echo home_url('/services/creativeforce/'); ?>">
                    <div class="title-wrap">
                        <h2>CreativeForce</h2>
                        <p>AI×RPAソリューション開発</p>
                    </div>
                    <p class="catch-wrap">設計から導入まで、完全オーダーメイド</p>
                    <ul class="outline-wrap">
                        <li>AI×RPA・WEB-SI統合開発による包括的ソリューション</li>
                        <li>モダンWEB技術 × Power Platform連携</li>
                        <li>業種別特化ソリューション提供</li>
                        <li>BizScan結果を基にした最適設計</li>
                    </ul>
                    <?php
                    /* 料金は表示しない
                    <div class="price-wrap">
                        <p class="price-text">250<span>万円～</span></p>
                        <p>スタンダード〜エンタープライズ</p>
                    </div>
                    */
                    ?>
                    <div class="btn-wrap">
                        <a href="<?php echo home_url('/services/creativeforce/'); ?>" class="btn-link">詳細を見る</a>
                    </div>
                    </a>
                </li>
                <li class="services-content-block-item">
                    <a href="<?php echo home_url('/services/guardian/'); ?>">
                    <div class="title-wrap">
                        <h2>Guardian</h2>
                        <p>運用・保守・継続改善サービス</p>
                    </div>
                    <p class="catch-wrap">24時間365日、あなたのAI×RPAを守る</p>
                    <ul class="outline-wrap">
                        <li>24時間システム監視・障害対応</li>
                        <li>データ分析による継続的改善提案</li>
                        <li>最大99.5%の稼働率保証（SLA）</li>
                    </ul>
                    <?php
                    /* 料金は表示しない
                    <div class="price-wrap">
                        <p class="price-text"><span>月額</span>10<span>万円～</span></p>
                        <p>ライト〜プレミアムプラン</p>
                    </div>
                    */
                    ?>
                    <div class="btn-wrap">
                        <a href="<?php echo home_url('/services/guardian/'); ?>" class="btn-link">詳細を見る</a>
                    </div>
                    </a>
                </li>
                <li class="services-content-block-item">
                    <a href="<?php echo home_url('/services/nextgenlab/'); ?>">
                    <div class="title-wrap">
                        <h2>NextGen .Lab</h2>
                        <p>社内AI×RPA人材育成プログラム</p>
                    </div>
                    <p class="catch-wrap">実践型研修で課題発見力を身につける人材を育成</p>
                    <ul class="outline-wrap">
                        <li>Microsoft公式カリキュラム活用</li>
                        <li>実案件OJTによる実践的スキル習得</li>
                        <li>社内の競争力・専門性向上</li>
                    </ul>
                    <div class="btn-wrap">
                        <a href="<?php echo home_url('/services/nextgenlab/'); ?>" class="btn-link">詳細を見る</a>
                    </div>
                    </a>
                </li>
            </ul>
        </div>
    </section>

    <section class="content-block content-block-flow">
        <h2 class="content-title">導入の流れ</h2>
        <div class="content-text">
            <ul class="services-content-block">
                <li>
                    <div class="num">01</div>
                    <div class="process-content">
                        <h2>診断・課題発見</h2>
                        <p>BizScanで業務分析<br>自動化ポイントを特定</p>
                    </div>
                </li>
                <li>
                    <div class="num">02</div>
                    <div class="process-content">
                        <h2>設計・開発・導入</h2>
                        <p>CreativeForceで<br>オーダーメイド開発・導入</p>
                    </div>
                </li>
                <li>
                    <div class="num">03</div>
                    <div class="process-content">
                        <h2>運用・改善</h2>
                        <p>Guardianで安定運用<br>継続的な効果向上</p>
                    </div>
                </li>
            </ul>
            <p class="flow-text">NextGen Labにより社内人材も同時に育成し、長期的な自立・成長をサポート</p>
        </div>
    </section>

</div>