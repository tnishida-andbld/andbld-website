# I-0004 Final Implementation Plan

## Status

Approved by Human. Implementation may start after this plan is recorded.

### Revision 2026-10-25

ローカルテーマ実装は Human Acceptance 済み（D-0009）。この計画の当初文面は履歴として残す。次の決定が、抵触する箇所に優先する。

- D-0010: 採用文言。共通CTAの英語見出し、バリューサイクルのラベル、TOPの導線、SERVICESの見出し
- D-0011: 301は旧4パスのみ。派生URLは今回の対象外
- D-0012: `headfoot.css` と `page-contents.css` のキャッシュ対策

Issue は Done ではない。Push、Draft PR、Development 反映、Development Human Review、Production 反映は未実施。

## Goal

アンドビルドの新MVV・事業内容に合わせ、主要3ページと共通導線を刷新する。

中心メッセージ:

> 挑戦を、実装する。

## Scope

### Update

- TOP
- ABOUT
- `/services/`（表示上は「事業内容」）
- 共通CTA
- グローバルナビ表示名 `サービス` → `事業内容`
- ABOUT / OUTLINE の事業内容
- 旧4サービスURLの301リダイレクト

### Keep

- CAREERS
- CONTACT
- Footer基本構造
- BLOG / NEWS機能
- GLOSSARY
- EBOOK
- 問い合わせ機能
- WordPress本体
- プラグイン
- 旧4サービス個別テンプレートファイル

## Legacy Service URL Decision

Search Console 過去12か月実績:

| URL | Clicks | Impressions | CTR | Avg. position |
|---|---:|---:|---:|---:|
| `/services/bizscan/` | 12 | 96 | 12.5% | 7.9 |
| `/services/creativeforce/` | 1 | 210 | 0.5% | 3.1 |
| `/services/guardian/` | 2 | 202 | 1.0% | 3.6 |
| `/services/nextgenlab/` | 2 | 615 | 0.3% | 17.7 |

Human Decision:

- 4URLとも `/services/` へ301リダイレクトする。
- 404 / 410にはしない。
- 旧4サービス個別テンプレートファイルは削除せず、将来OUR BUSINESS等の詳細ページへ転用できるよう保持する。

Redirects:

- `/services/bizscan/` → `/services/` (301)
- `/services/creativeforce/` → `/services/` (301)
- `/services/guardian/` → `/services/` (301)
- `/services/nextgenlab/` → `/services/` (301)

第一候補はテーマ内 `functions.php` の `template_redirect` を使い、`home_url('/services/')` へ `wp_safe_redirect(..., 301)` する。Production URLをハードコードしない。

D-0011: 対象は上記4パス（末尾スラッシュの有無を含む）だけとする。`/services/bizscan/feed/` などの派生URLは今回の301に含めない。派生URLを将来どう扱うかは未決定。

## Implementation Branch

仕様策定ブランチ:

- `docs/i-0004-site-content-update`

実装用ブランチ:

- `feature/i-0004-site-content-update`

実装用ブランチは、I-0004仕様・最終計画を含むdocsブランチを起点に作成する。

## Main Implementation Files

- `wordpress/wp-content/themes/andbld/page-frontpage.php`
- `wordpress/wp-content/themes/andbld/template-parts/inc/about-page.php`
- `wordpress/wp-content/themes/andbld/template-parts/inc/services-page.php`
- `wordpress/wp-content/themes/andbld/section-parts/cta-block1.php`
- `wordpress/wp-content/themes/andbld/functions.php`
- `wordpress/wp-content/themes/andbld/css/toppage-contents.css`
- `wordpress/wp-content/themes/andbld/css/page-contents.css`

`template-parts/content-page.php` は旧4サービステンプレートのルーティングを保持するため原則変更しない。301はテンプレート描画前に処理する。

## TOP

Order:

1. FV
2. `(WHO WE ARE)`
3. `(SERVICE)`
4. `(OUR APPROACH)`
5. BLOG
6. NEWS
7. 共通CTA

BLOGはI-0001の横スクロールUIを維持する。

D-0010 のTOP導線:

- WHO WE ARE のリンク文言は「私たちについて」。遷移先は `/about/`
- SERVICE は「01 Technical」「02 Business」。どちらも `/services/`
- 企画時仕様の「ABOUT US」「事業内容」というリンク文言は、この導線に更新する
- FVは「挑戦を、実装する。」と「事業を理解し、技術で実現し、人とAIをつなぐ。」仕様書にあったFV本文段落は、Acceptされた実装にはない

## ABOUT

Order:

1. `(PHILOSOPHY)`
2. `(VISION)`
3. `(MISSION)`
4. `(OUR APPROACH)`
5. `(VALUES)`
6. `(&BLD VALUE CYCLE)`（D-0010。計画時の `(andbld Value Cycle)` を更新）
7. `(OUTLINE)`
8. `(ACCESS)`

OUTLINE事業内容:

> AI・Webシステム開発、業務自動化、IT・AIコンサルティング、新規事業支援、自社事業の企画・運営

旧4サービスを列挙する「提供サービス」は削除する。

## `/services/` 事業内容

Order:

1. INTRODUCTION
2. `(TECHNOLOGY)` / 技術領域
3. `(BUSINESS)` / 事業領域
4. `(OUR BUSINESS)`
5. `(OUR APPROACH)`
6. 共通CTA

技術領域:

- AI開発・導入支援
- Webシステム開発
- RPA・業務自動化
- AIエージェント開発
- CMS構築
- API・システム連携
- 保守・運用支援

事業領域:

- IT・AIコンサルティング
- DX推進支援
- AI活用戦略
- 新規事業支援

OUR BUSINESS:

- EC事業
- 海外事業
- 商品開発

現時点ではOUR BUSINESSの個別ページは作成しない。

D-0010 の見出し。仕様書の見出しは履歴として残し、こちらを正とする。

- TECHNOLOGY: 事業の挑戦を、確かな技術で実装する。
- BUSINESS: 事業の構想から成長まで、実践知で伴走する。
- OUR BUSINESS: 私たち自身も、挑戦し続ける。

技術領域・事業領域の項目名と、OUR BUSINESS の3分類は計画時のまま。カード上の表示は `TECHNOLOGY` / 技術領域、`BUSINESS` / 事業領域。説明文の正は Phase 3 Commit の `template-parts/inc/services-page.php`。

## Common CTA

D-0010 を正とする。計画時の英語見出しは、直下に履歴として残す。

Main:

> あなたの挑戦を、次の価値へ。

Body:

> AI導入、Webシステム開発、業務改善、新規事業など、まずは実現したいことをお聞かせください。

- 英語見出しは表示しない
- PC / SP とも左揃え。ボタン内の文字は中央
- ボタンは「お問い合わせ」。遷移先は `/contact/`
- `/contact/` では共通CTAを出さない
- ボタンコンテナの下余白は 30px。セクション既存の下パディングは維持する

### Superseded by D-0010

English:

> Let's Build Together.

## Global Navigation

- Before: `サービス`
- After: `事業内容`
- Link: `/services/`

現行テーマは `wp_nav_menu()` を使うため、メニュー文言はWordPress管理画面側の作業になる可能性が高い。テーマへ不要なハードコードは追加しない。

2026-10-25 時点で未実施。変更先「事業内容」は撤回していない。実施時期は未決定。

## JavaScript

原則追加しない。VALUES / Value Cycle等はPHP + CSSで実装する。

## Implementation Order

1. TOP PHP + CSS
2. ABOUT PHP + CSS
3. SERVICE PHP + CSS
4. 共通CTA
5. 301 redirect
6. PHP / static check
7. Local Human Review
8. Draft PR
9. Development dry-run
10. Development deploy
11. Development Human Review
12. Productionは別途Human確認後に反映

## Acceptance

### Content

- TOPが新企業ポジショニングを表現
- ABOUTが新MVVと一致
- `/services/` が新事業構成と一致
- 旧4サービスが主要導線に表示されない
- 共通CTAが新コピー
- 日本語中心の表現ルールを維持

### Redirect

4旧URLすべて:

- HTTP 301
- Locationは同一環境の `/services/`
- Redirect loopなし

### Human Review

- PC
- SP
- 操作性
- 文字量・改行
- リンク
- Console Error
- Header / Footer
- BLOG横スクロール

### Regression

- BLOG
- NEWS
- CAREERS
- CONTACT
- 問い合わせ
- GLOSSARY
- EBOOK

AI自己検証のみではDoneとしない。Human Acceptanceを必須とする。

## Local implementation record

2026-10-25 にローカルテーマ実装を Human Acceptance した（D-0009）。ブランチは `feature/i-0004-site-content-update`。

| Phase | Commit | 内容 |
|---|---|---|
| 1 TOP | `56a044fa959361a59959d09f56c17e0f5df9aba9` | ホームページ |
| 2 ABOUT | `4aa04ffb90d8e70b71766db3a914b12f3fbe1023` | About |
| 3 SERVICES | `acce8a9a4ef4eef230d9d7b595ca2f5401e5924a` | 事業内容ページ |
| 4 共通CTA | `7008cf34be8c1a9e177ded50f624a99a17d9b1e5` | 英語見出しなし、左揃え |
| 4-B 301 | `dc99fb8d9831cd9b7b37c9151fd0d3e44d06f2ac` | 旧4パスを `/services/` へ |
| CSSキャッシュ | `70c316e5f6c9df4b4702bb75a9de5df52f921330` | D-0012 |

### 未実施

- GitHub への Push
- Draft PR
- Development への反映
- Development Human Review
- Production への反映

### 未対応。ここでは確定しない

- ナビゲーション「サービス」→「事業内容」の実施時期
- `/services/` の H1 と固定ページタイトルを変えるか
- TOP の SEO タイトルを変えるか。企画時の「明示承認なしに title / SEO を変えない」は維持する
- `page-sitemap.xml` からの旧4URL除外の方法と時期
- ログイン済みの旧ページプレビュー確認
- Development / Production でのキャッシュ確認
- `headfoot.css` と `page-contents.css` 以外の `@import` をキャッシュ対策の対象にするか

## CSS cache

D-0012。`headfoot.css` と `page-contents.css` は `style.css` の `@import` から外し、`toppage-contents.css` と同じく `filemtime()` 付きで enqueue する。`style.css` のバージョンも `filemtime()` とする。読み込み順は `style.css`、`headfoot.css`、`page-contents.css`、`toppage-contents.css`。

variable、base、layout、firstview、feed、single、ebook、custom の `@import` は変えていない。

### Revision 2026-10-26

I-0004 の Production 反映と Human Acceptance が完了し、Issue を Done とする（D-0014）。上の「未実施」リストと Status 節の「Issue は Done ではない」は、2026-10-25 時点の記録として残す。

- PR #10 MERGED。確定コミット `56c0d2dad54a07b5a238964bff29b2bdfc39d41e`
- Production 反映日: 2026-10-26。Human が FileZilla でテーマ 10 ファイルを個別アップロード
- SHA-256 照合 10/10 PASS
- Production UAT: ページ 4/4、301（末尾スラッシュなし）4/4、CTA 6/6、最終回帰 9/9 PASS
- I-0005 保護 2/2 PASS。Git 取り込みは別作業
- Human Acceptance 承認済み

「未対応。ここでは確定しない」の項目は、D-0009 / D-0014 のとおり I-0004 の Done を妨げない。
