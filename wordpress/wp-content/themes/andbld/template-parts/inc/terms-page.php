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
    <section class="content-block content-block-terms">
      <div class="content-kiyaku">

        <div class="content-wrap">
          <p>この利用規約（以下「本規約」といいます）は、アンドビルド株式会社（以下「当社」といいます）が運営するウェブサイト（以下「本サイト」といいます）の利用条件を定めるものです。本サイトをご利用になる場合には、本規約にご同意いただいたものとみなします。</p>
        </div>

        <div class="content-wrap">
          <h2>1. 本規約の適用</h2>
          <div class="content-kiyaku-text">
            <p>本規約は、本サイトを利用するすべてのユーザーに適用されます。本サイトを利用することにより、ユーザーは本規約の全ての条項に同意したものとみなされます。</p>
          </div>
        </div>

        <div class="content-wrap">
          <h2>2. サービス内容</h2>
          <div class="content-kiyaku-text">
            <p>本サイトは、当社の事業内容、サービス、企業情報等を紹介するコーポレートサイトです。当社は、本サイトを通じて以下のサービスを提供します。</p>
          </div>

          <div class="content-kiyaku-text">
            <ul>
              <li>企業情報の提供</li>
              <li>サービス・製品情報の提供</li>
              <li>お問い合わせの受付</li>
              <li>資料ダウンロードの提供</li>
              <li>その他当社が適切と判断する情報の提供</li>
            </ul>
          </div>
        </div>

        <div class="content-wrap">
          <h2>3. 利用にあたっての禁止事項</h2>
          <div class="content-kiyaku-text">
            <p>ユーザーは、本サイトの利用にあたり、以下の行為を行ってはなりません。</p>
          </div>
          <div class="content-kiyaku-text">
            <ul>
              <li>当社または第三者の著作権、商標権、その他の知的財産権を侵害する行為</li>
              <li>本サイトの運営を妨害する行為</li>
              <li>本サイトに対する不正アクセス行為</li>
              <li>コンピューターウイルス等の有害なプログラムを送信する行為</li>
              <li>他のユーザーまたは第三者に迷惑をかける行為</li>
              <li>虚偽の情報を送信する行為</li>
              <li>営利目的での本サイトの利用（当社の事前の書面による承諾がある場合を除く）</li>
              <li>本サイトのコンテンツを無断で複製、転載、配布する行為</li>
              <li>法令に違反する行為またはそのおそれのある行為</li>
              <li>公序良俗に反する行為</li>
              <li>その他当社が不適切と判断する行為</li>
            </ul>
          </div>
        </div>

        <div class="content-wrap">
          <h2>4. 知的財産権</h2>

          <h3>著作権</h3>
          <div class="content-kiyaku-text">
            <p>本サイトに掲載されている文章、画像、動画、音声、その他のコンテンツ（以下「本コンテンツ」といいます）の著作権は、当社または正当な権利を有する第三者に帰属します。</p>
          </div>

          <h3>商標権</h3>
          <div class="content-kiyaku-text">
            <p>本サイトに掲載されている当社の商標、ロゴマーク、サービス名称等は、当社または関連会社の商標または登録商標です。これらを当社の書面による事前の承諾なく使用することを禁じます。</p>
          </div>

          <h3>利用許諾</h3>
          <div class="content-kiyaku-text">
            <p>ユーザーは、本サイトの個人的かつ非商用目的での利用についてのみ、本コンテンツを閲覧、ダウンロードすることができます。</p>
          </div>
        </div>

        <div class="content-wrap">
          <h2>5. 免責事項</h2>

          <h3>情報の正確性</h3>
          <div class="content-kiyaku-text">
            <p>当社は、本サイトに掲載する情報の正確性、完全性、有用性等について、いかなる保証もいたしません。</p>
          </div>

          <h3>システム障害・メンテナンス</h3>
          <div class="content-kiyaku-text">
            <p>当社は、システム障害、メンテナンス、通信回線の障害等により本サイトが利用できなくなった場合について、いかなる責任も負いません。</p>
          </div>

          <h3>外部サイトへのリンク</h3>
          <div class="content-kiyaku-text">
            <p>本サイトから他のウェブサイトへのリンクが含まれている場合がありますが、当社はリンク先のサイトの内容について一切責任を負いません。</p>
          </div>

          <h3>損害に対する責任</h3>
          <div class="content-kiyaku-text">
            <p>当社は、本サイトの利用に関連してユーザーまたは第三者が被った損害について、当社に故意または重大な過失がある場合を除き、一切責任を負いません。</p>
          </div>
        </div>

        <div class="content-wrap">
          <h2>6. サービス内容の変更・中断・終了</h2>
          <div class="content-kiyaku-text">
            <p>当社は、ユーザーに事前に通知することなく、本サイトの内容を変更、中断、または終了することができるものとします。これによりユーザーまたは第三者に生じた損害について、当社は一切責任を負いません。</p>
          </div>
        </div>

        <div class="content-wrap">
          <h2>7. 本規約の変更</h2>
          <div class="content-kiyaku-text">
            <p>当社は、必要に応じて本規約を変更することがあります。規約を変更した場合は、本サイト上に掲載することにより、ユーザーに通知いたします。変更後の規約は、本サイトに掲載された時点から効力を生じるものとします。</p>
          </div>
        </div>

        <div class="content-wrap">
          <h2>8. 準拠法および管轄裁判所</h2>
          <div class="content-kiyaku-text">
            <p>本規約の解釈および適用は日本法に準拠するものとし、本サイトに関連して生じた紛争については、東京地方裁判所を第一審の専属的合意管轄裁判所とします。</p>
          </div>
        </div>

        <div class="kiyaku-footer-info">
            <p><strong>制定日：</strong> 2023年11月1日</p>
        </div>

      </div>
    </section>
</div> 