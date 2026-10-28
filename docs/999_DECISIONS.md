# andbld AI Development OS

# Decisions

---

## D-0001

### Date

2026-07-10

### Status

Approved

### Decision

プロジェクト名称を

「andbld AI Development OS」

とする。

### Reason

AIを単なるツールではなく、

会社全体の開発基盤として育てるため。

---

## D-0002

### Date

2026-07-10

### Status

Approved

### Decision

GitHubでは

WordPress本体ではなく、

andbldカスタムテーマと開発ドキュメントを管理する。

### Reason

環境依存を減らし、

安全で保守しやすいリポジトリ構成とするため。

---

## D-0003

### Date

2026-07-10

### Status

Approved

### Decision

開発環境は

Local

↓

Development

↓

Production

の3環境で運用する。

### Reason

品質確認を行ってから本番公開するため。

---

## D-0004

### Date

2026-07-10

### Status

Approved

### Decision

AI開発チームの役割を以下とする。

| Role | Owner |
|------|-------|
| Product Owner | 西田達也 |
| AI Development Architect | ChatGPT |
| AI Developer | Cursor |
| AI Tech Lead | Claude Code（導入後） |
| AI Software Engineer | Devin（導入後） |

### Reason

AIごとの責任範囲を明確にするため。

---

## D-0005

### Date

2026-08-21

### Status

Approved

### Decision

AI実装の完了条件にHuman Reviewを必須とする。

AI（Cursor / Claude Code / Devin等）が実装・自己検証を完了しても、それだけではDoneとしない。

UI変更については最低限、以下を確認し、人間によるAcceptanceを経てDoneとする。

- PC実ブラウザ
- スマートフォン表示
- 操作性
- 既存機能への影響
- Console Error

AIは「実装者兼一次検証者」、人間は「最終Acceptance責任者」とする。

### Reason

I-0001において、AIの実装完了報告と実UXの達成が一致しないケースが確認されたため。

コード上の成立だけでなく、人間による最終Acceptanceを経ることで品質と判断の責任を明確にするため。

---

## D-0006

### Date

2026-08-21

### Status

Approved

### Related

I-0002
P-0001

### Decision

ローカル開発環境は Git 管理テーマを Single Source of Truth とする。

- Git working tree の `wordpress/wp-content/themes/andbld/` を唯一の編集元とする
- XAMPP 側 `wp-content/themes/andbld` は Junction で Git 管理テーマを参照する
- XAMPP 側にテーマの別コピーを持たない
- 人間・Cursor・Claude Code は Git working tree を参照する
- Devin は GitHub repository を参照する
- localhost は Human Review 用の実行環境とする

### Reason

I-0001 で Git 側と XAMPP 側が別コピーだったため、

AI が変更したコードと Human Review 対象コードが一致しない問題が発生した。

二重管理をなくし、

「AI が編集するコード = localhost で実行するコード」

とするため。

---

## D-0007

### Date

2026-08-26

### Status

Approved

### Related

I-0003
D-0003
D-0005
D-0006
L-0003

### Decision

Development環境へのテーマ反映は、Git管理テーマを Single Source of Truth とし、GitHub Actions + rsync over SSH で行う。

- デプロイ対象は `wordpress/wp-content/themes/andbld/` のみ
- 現状の実行手段は `workflow_dispatch` による手動実行のみ
- `mode` の初期値は `dry-run`。実変更は `mode=deploy` のときだけ行う
- `main` push による自動デプロイはまだ有効化しない（P-0002）
- Production への自動デプロイは対象外とする
- Development と Production の鍵・パス・URL は分離する
- `deploy` 時は、テーマディレクトリの外へ UTC タイムスタンプ付きバックアップを作成してから rsync し、その後 Smoke Test を行う
- GitHub Actions が成功しても Done としない。D-0005 に従い Human Review を必須とする
- Development には Basic 認証がある。Smoke Test は GitHub Environment Secrets の認証情報を使って HTTP 2xx を確認する

I-0003 は、手動デプロイと Human Review まで完了し Done とする。

### Reason

I-0001 では Development / Production への反映を手動アップロードで行い、最終 Commit のファイルだけを対象にしたことで漏れが発生した（L-0003）。

テーマディレクトリ全体を Git から同期することで、漏れを構造的に防ぎ、再現可能な Development 反映経路を確立するため。

---

## D-0008

### Date

2026-08-26

### Status

Approved

### Related

I-0003.5
D-0005
L-0007
L-0008

### Decision

新しい AI セッションは、チャット履歴ではなくリポジトリ内の `docs/HANDOFF.md` から現在地を復元する。

- HANDOFF は索引／スナップショットであり、Decision / Lesson / Rules / README の本文を複製しない
- 新セッションは HANDOFF を読んだあと、現在地を Human へ報告し、確認後に指定 Issue へ進む
- HANDOFF を読んだだけで次 Issue を選択・実装しない
- GitHub を参照できる場合はリポジトリ上の HANDOFF を取得する。アクセスできない場合は Human へ添付を依頼し、取得前は実装しない
- 接続情報・Secret・サーバー絶対パス・ローカル絶対パスは HANDOFF に書かない

I-0003.5 は HANDOFF 新設と関連 OS 更新まで完了し Done とする。

### Reason

I-0001〜I-0003 の完了後も、進行中 Issue・次の一手・Issue 開始手順は会話履歴に残っており、新しいチャット／新しい AI がリポジトリだけでは現在地を復元できなかったため。

---

## D-0009

### Date

2026-10-25

### Status

Approved

### Related

I-0004
D-0005
D-0007
`docs/I-0004_FINAL_IMPLEMENTATION_PLAN.md`
`docs/I-0004_IMPLEMENTATION_SPEC.md`

### Decision

I-0004 のローカルテーマ実装6 Commitを Human Acceptance とする。ブランチは `feature/i-0004-site-content-update`。

| Phase | Commit | 内容 |
|---|---|---|
| 1 TOP | `56a044fa959361a59959d09f56c17e0f5df9aba9` | ホームページ |
| 2 ABOUT | `4aa04ffb90d8e70b71766db3a914b12f3fbe1023` | About |
| 3 SERVICES | `acce8a9a4ef4eef230d9d7b595ca2f5401e5924a` | 事業内容ページ |
| 4 共通CTA | `7008cf34be8c1a9e177ded50f624a99a17d9b1e5` | 共通CTA |
| 4-B 301 | `dc99fb8d9831cd9b7b37c9151fd0d3e44d06f2ac` | 旧4パスの301 |
| CSSキャッシュ | `70c316e5f6c9df4b4702bb75a9de5df52f921330` | D-0012 |

文言の正は D-0010。301の範囲は D-0011。CSSの読み込みは D-0012。

I-0004 は Done にしない。次は未実施である。

- GitHub への Push
- Draft PR
- Development への反映
- Development Human Review
- Production への反映

次も未対応であり、この決定では実施時期も変更可否も確定しない。

- ナビゲーション「サービス」→「事業内容」（計画上の変更先は維持。未実施）
- `/services/` の H1 と固定ページタイトル
- TOP の SEOタイトル（明示承認なしに変えない、は維持）
- サイトマップからの旧4URL除外
- ログイン済み旧ページプレビューの確認
- Development / Production のキャッシュ確認
- その他の CSS `@import` のキャッシュ管理

### Reason

ローカル実装の Acceptance と、未反映・未決定を分けて記録しないと、テーマ実装済みを Issue 完了や本番反映と誤読するため。

### Subsequent record

この本文は 2026-10-25 のローカル Acceptance 時点の記録である。上の「未実施」リストは、その時点の記録として残す。その後の実施状況は D-0013。

---

## D-0010

### Date

2026-10-25

### Status

Approved

### Related

I-0004
D-0009

### Decision

Accept されたテーマ実装の文言を、I-0004 のコンテンツ SoT とする。企画時の文面は仕様書と最終計画に履歴として残す。抵触箇所は本決定が優先する。

TOP:

- FVは「挑戦を、実装する。」と「事業を理解し、技術で実現し、人とAIをつなぐ。」仕様書のFV本文段落は採用しない
- WHO WE ARE のリンクは「私たちについて」→ `/about/`。仕様書の「ABOUT US」は更新する
- SERVICE は「01 Technical」「02 Business」。どちらも `/services/`。仕様書の「事業内容」リンク文言は更新する
- 構成は FV、WHO WE ARE、SERVICE、OUR APPROACH、BLOG、NEWS、共通CTA

ABOUT:

- PHILOSOPHY、VISION、MISSION、OUR APPROACH、VALUES の文言は仕様書どおり
- バリューサイクルのラベルは `(&BLD VALUE CYCLE)`。計画と仕様の `(andbld Value Cycle)` を更新する
- 見出し「余白から、次の挑戦へ。」と本文、OUTLINE の事業内容は計画どおり

SERVICES:

- 導入見出しと本文、技術7項目、事業4領域、OUR BUSINESS の3分類、OUR APPROACH の5段階は維持する
- TECHNOLOGY の見出しは「事業の挑戦を、確かな技術で実装する。」
- BUSINESS の見出しは「事業の構想から成長まで、実践知で伴走する。」
- OUR BUSINESS の見出しは「私たち自身も、挑戦し続ける。」
- 仕様書の旧見出しと OUR BUSINESS 本文は更新する。説明文の正は `acce8a9a4ef4eef230d9d7b595ca2f5401e5924a` の `template-parts/inc/services-page.php`
- 個別の OUR BUSINESS ページは作らない

共通CTA:

- 英語見出し「Let's Build Together.」は表示しない。計画と仕様の英語見出しを更新する
- 主文は「あなたの挑戦を、次の価値へ。」
- 本文は「AI導入、Webシステム開発、業務改善、新規事業など、まずは実現したいことをお聞かせください。」
- PC / SP とも左揃え。ボタン内の文字は中央
- ボタンは「お問い合わせ」。遷移先は `/contact/`
- `/contact/` では共通CTAを出さない
- ボタンコンテナの下余白は 30px。セクション既存の下パディングは維持する

### Reason

実装レビューでCTAの英語見出し削除と左揃えが確定し、その後の Acceptance でテーマ上の文言が確定したため。企画文書に旧文面を残すと、次の実装が旧CTAへ戻る。

---

## D-0011

### Date

2026-10-25

### Status

Approved

### Related

I-0004
D-0009
最終実装計画の Legacy Service URL Decision

### Decision

旧URLの301は、次の4パスだけを対象とする。末尾スラッシュの有無は同一対象とする。

- `/services/bizscan/`
- `/services/creativeforce/`
- `/services/guardian/`
- `/services/nextgenlab/`

転送先は同一環境の `/services/`。ステータスは 301。Production のURLはハードコードしない。

`/services/bizscan/feed/` のような派生URLは、今回の301に含めない。派生URLを将来301にするかは未決定。

未ログインの `?preview=true` は301する。ログイン済みで編集できるプレビューを301から外す実装はある。その動作確認は未了であり、本決定は確認済みとはしない。

### Reason

最終計画は4URLの301を既に決めていた。フィード等まで広げる判断はしておらず、Acceptance の範囲も4パスのため。

---

## D-0012

### Date

2026-10-25

### Status

Approved

### Related

I-0004
D-0009

### Decision

I-0004 で変更した CSS が、更新後に再取得されるようにする。

- `headfoot.css` と `page-contents.css` を `style.css` の `@import` から外す
- `toppage-contents.css` と同じく、`wp_enqueue_style()` と `filemtime()` で読む
- `style.css` のクエリバージョンも `filemtime()` にする。固定の `1.0.0` のままだと、古い `style.css` が `@import` を残す
- 順は `style.css`、`headfoot.css`、`page-contents.css`、`toppage-contents.css`
- 各ファイルは1回だけ読む
- variable、base、layout、firstview、feed、single、ebook、custom の `@import` は変えない

残りの `@import` を同じ方式にするかは未決定。Development と Production のキャッシュ実地確認も未了。

### Reason

`style.css?ver=1.0.0` の `@import` は、子CSSのURLにバージョンが付かない。ブラウザが旧 `headfoot.css` を持つと、Accept 済みのCTA色と余白が旧デザインになるため。

---

## D-0013

### Date

2026-10-25

### Status

Approved

### Related

I-0004
D-0005
D-0007
D-0009
D-0011
D-0012

### Decision

D-0009 の本文はローカル Acceptance 時点の記録として残す。その後、次まで完了した。

- I-0004 の確定仕様に対するテーマ実装は完了している
- 承認済みの実装は Push 済みである
- Development への反映は完了している。一時 inspect の追加と削除は workflow のみで、UAT 対象のテーマファイルは変えていない
- Development UAT は 10 項目すべて PASS である
- 一時 inspect mode の削除は完了している。workflow に inspect は残っていない
- GitHub Environment `development` の Deployment branches は `main` のみに戻している。一時追加した `feature/i-0004-site-content-update` の許可は削除済みである
- PR #10（`feature/i-0004-site-content-update` → `main`）は OPEN / Draft である。Ready for Review も Merge もしていない

Production への反映は未実施であり、未承認である。

I-0004 は Done にしない。Production が未承認であるため。

D-0009 で未決定のまま残したものは、この記録でも確定しない。

- ナビゲーション「サービス」→「事業内容」
- `/services/` の H1 と固定ページタイトル
- TOP の SEOタイトル
- サイトマップからの旧4URL除外
- ログイン済み旧ページプレビューの確認
- Production の CSS キャッシュ確認
- その他の CSS `@import` のキャッシュ管理

Development の CSS キャッシュは、UAT の対象として PASS である。Production のキャッシュ確認は D-0012 のとおり未了である。

### Reason

Acceptance 後の Push、Development 反映、UAT、一時 inspect の削除、Environment の許可ブランチ復元が完了したため。D-0009 の「未実施」を書き換えると、当時何が未実施だったかが残らない。Production 未承認のまま Done にすると、本番反映済みと誤読するため。

---

## D-0014

### Date

2026-10-26

### Status

Approved

### Related

I-0004
D-0005
D-0009
D-0013
PR #10
`docs/I-0004_FINAL_IMPLEMENTATION_PLAN.md`

### Decision

I-0004 の Production 反映と Human Acceptance を完了とし、I-0004 を Done とする。

D-0009〜D-0013 の本文は、当時の記録として残す。本決定が、その後の実施結果と Done 判定の正とする。

GitHub に独立した I-0004 Issue は存在しない。追跡実体は PR #10（MERGED / CLOSED）である。完了記録は OS 文書と PR #10 コメントとする。

- Production 反映日: 2026-10-26
- 方式: Human が FileZilla でテーマ 10 ファイルを個別アップロード（同期・削除なし）
- PR: #10
- 確定コミット: `56c0d2dad54a07b5a238964bff29b2bdfc39d41e`
- 対象: `functions.php`、`page-frontpage.php`、`style.css`、`css/headfoot.css`、`css/page-contents.css`、`css/toppage-contents.css`、`section-parts/cta-block1.php`、`template-parts/inc/about-page.php`、`template-parts/inc/services-page.php`、`assets/images/andbld-value-cycle-icons.png`
- 反映後 SHA-256 照合: 10/10 PASS
- バックアップ: All-in-One WP Migration（I-0005 後、ローカル保存済み）。I-0005 後の Production テーマ退避済み。I-0004 上書き対象の既存 9 ファイルは反映前に旧ベースラインと一致。復元テストは未実施。Xserver 自動バックアップは完了待ちのため、完了扱いしない
- Production 検証: 主要ページ 4/4 PASS。旧サービス URL の 301（末尾スラッシュなし）4/4 PASS。CTA 6/6 PASS。最終回帰テスト 9/9 PASS。総合 PASS
- 最終回帰: PC / SP（TOP・ABOUT・SERVICES）、BLOG 一覧と横スクロール、NEWS 一覧、CAREERS 表示、CONTACT ページ表示とフォーム動作、GLOSSARY・EBOOK 表示、Console に重大な JavaScript エラーなし、共通ヘッダー・フッターに崩れなし。CONTACT フォームの実送信は未確認
- I-0005 保護: `template-parts/content-page.php` と `template-parts/inc/customer-harassment-policy-page.php` はアップロード対象外。前後 SHA-256 2/2 PASS（変更なし）。Git 取り込みは別作業
- Human Acceptance: 2026-10-26 承認

I-0004 は Done とする。次は I-0004 の対象外として残す。

- ナビゲーション「サービス」→「事業内容」
- `/services/` の H1 と固定ページタイトル
- TOP の SEOタイトル
- サイトマップからの旧4URL除外
- I-0005 の Git 正式取り込みと Development 同期
- Production 自動デプロイ
- Xserver 自動バックアップの完了確認
- バックアップ復元テスト
- ログイン済み旧ページプレビュー
- 残りの CSS `@import` のキャッシュ管理

### Reason

Production 反映、SHA-256 照合、UAT、最終回帰、Human Acceptance が揃ったため。D-0005 に従い、AI 自己検証ではなく Human 承認をもって Done とする。対象外事項を I-0004 に混ぜると、未実施を Issue 未完了と誤読するため。

---

## D-0015

### Date

2026-10-26

### Status

Approved

### Related

I-0005
I-0006
D-0005
D-0014
PR #12

### Decision

I-0005 の Production 先行実装を Git へ正式取り込み、Git 部分を Done とする。

Development / Local へのテーマ反映と WordPress データの同期は I-0005 の完了条件に含めない。それらは I-0006 とする。

- PR: #12（MERGED / CLOSED）
- Merge SHA: `886db0503037a23a015209d47a78da423f37ce95`
- Merge 日時: 2026-10-26 16:57:29 JST
- 変更: テーマ 4 ファイル、102 additions / 1 deletion
- 対象: `template-parts/content-page.php`、`template-parts/inc/customer-harassment-policy-page.php`、`footer.php`、`css/page-contents.css`
- Production 取得コピーとの SHA-256 比較: 4/4 一致
- Production 現行サーバ上のファイルとの直接ハッシュ照合は未確認
- `css/layout.css` のブログ個別ページリンク色変更は I-0005 対象外。別途判断
- Production への再アップロードは今回行わない。先行公開済みのテーマ実装を Git へ合わせた作業である
- Development へのテーマデプロイは、I-0006 の DB 同期計画と調整してから行う

I-0006 の方針:

- Production を WordPress コンテンツ・DB・uploads の基準とする
- GitHub `main` をテーマソースの基準とする
- Development / Local への同期前にバックアップと復元方法を確認する
- バックアップ復元試験は未実施。完了扱いしない
- URL 置換はシリアライズ対応を必須とする
- 環境固有の認証情報・設定を保持する
- メール送信・外部 API・Webhook・WP-Cron 等の副作用を防ぐ
- Development の検索エンジン非公開設定を確認する
- 各環境で固定ページ `/customer-harassment-policy/` の存在と表示を確認する

I-0006 の実作業は、この決定では開始しない。

実施結果と Done 判定は D-0016 を正とする。本決定の本文は計画時点の記録として残す。

### Reason

Production にだけあった方針ページ実装を Git 未管理のまま残すと、Development デプロイや後続改修で上書き・欠落する。Git 取り込みと環境再同期を分けて記録しないと、テーマが `main` にあることを環境同期完了と誤読するため。

---

## D-0016

### Date

2026-10-28

### Status

Approved

### Related

I-0006
I-0005
D-0005
D-0006
D-0007
D-0015
Actions run 40625104615

### Decision

I-0006 の WordPress 環境再同期を完了とし、I-0006 を Done とする。

D-0015 の本文は、I-0005 Git 取り込みと I-0006 着手前方針の記録として残す。本決定が、その後の実施結果と Done 判定の正とする。

GitHub に独立した I-0006 Issue は存在しない。追跡実体は OS 文書と GitHub Actions の Development デプロイ実行である。

目的:

- Production を WordPress コンテンツ・DB・uploads の基準とする
- GitHub `main` をテーマソースの基準とする
- 環境固有の認証情報・URL・検索エンジン設定・副作用防止を保持する
- Development / Local の表示を Production 由来データと Git テーマで揃える

実施結果:

- Production の DB・ファイルは変更していない
- Development は sidecar DB `andbld_i0006s1` を参照して稼働。旧 Development DB は残置
- Local は isolate DB `andbld_i0006_local_20261028`（接頭辞 `ab_`）を参照して稼働。旧 Local DB は残置
- URL 置換はシリアライズ対応で実施。`guid` は置換対象外
- Local テーマ Junction（Git テーマ参照）は維持
- Development テーマは GitHub Actions `Deploy to Development` で `main` を反映
- Dry-run: run `40624103115` / success / 変更 5 ファイル / 削除 0
- Deploy: run `40625104615` / SHA `3f8525f95bcb8262d24993fd81b0c900db7dcb34` / success
- Deploy 反映: `template-parts/inc/customer-harassment-policy-page.php`、`template-parts/content-page.php`、`footer.php`、`css/page-contents.css`、`page-frontpage.php`
- テーマバックアップ: `andbld.bak-20261028031013`（UTC）。自動ロールバックなし
- Deploy 後 Human Review 6 項目 PASS
- `/customer-harassment-policy/` は Production / Development / Local で表示確認済み。同期元 SQL に当該固定ページが無かったため、Development / Local は公開済み stub ページを追加し、本文は Git テーマが描画する
- Local 管理画面の認証後ログインは Human 確認済み
- Development の Basic 認証、検索エンジン非公開（`blog_public=0`）、`DISABLE_WP_CRON`、mu-plugin によるメール送信防止（`pre_wp_mail`）を確認。外部宛ての実送信テストは未実施

完了条件（D-0015 方針との対応）:

- Production をコンテンツ・DB・uploads の基準とした
- GitHub `main` をテーマ SoT とした
- 同期は新規 sidecar / isolate へ行い、既存 DB を上書きしなかった
- URL 置換はシリアライズ対応
- 環境固有設定を保持した
- メール・cron・検索エンジン公開の副作用を抑止した
- 方針ページを 3 環境で確認した
- Development テーマ反映と Human Review を完了した

切り戻し（値や絶対パスは書かない）:

- Development テーマ: live テーマを退避し、`andbld.bak-20261028031013` を戻す。手順は workflow コメント（D-0007）
- Development DB: `wp-config.php` の `DB_NAME` を sidecar 導入前の DB に戻す。旧 DB は削除していない
- Local DB: `DB_NAME` を旧 Local DB へ、`$table_prefix` を `wp_` へ戻す。isolate DB と作業前ダンプは残置
- Production は対象外

I-0006 は Done とする。次は I-0006 の対象外として残す。

- P-0002 `main` push 自動デプロイ
- Production 自動デプロイ
- `css/layout.css` の Production 専用差分（ブログ個別リンク色）
- Xserver 自動バックアップの完了確認と、そのバックアップからの復元テスト
- Local `cron` オプションに残る Yoast エントリ（実行時は `DISABLE_WP_CRON` と mu-plugin で抑止済み）
- メール実送信テスト、および leadin / AIOS / WP Super Cache 以外の外部連携プラグインの追加抑止
- `.gitignore` への `*.wpress` / `wordpress/wp-content/plugins/` 追加
- ナビ「サービス」→「事業内容」ほか D-0014 の未決事項
- 残置した旧 DB・旧バックアップの整理（削除してよいかは未決定）

### Reason

Production 由来データの同期、環境保護、Git テーマの Development 反映、方針ページの 3 環境表示、Human Review が揃ったため。D-0005 に従い、AI 自己検証ではなく Human 承認をもって Done とする。D-0015 の着手前方針を書き換えると、計画と実施の区別が残らない。
