# I-0004 Final Implementation Plan

## Status

Approved by Human. Implementation may start after this plan is recorded.

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

## ABOUT

Order:

1. `(PHILOSOPHY)`
2. `(VISION)`
3. `(MISSION)`
4. `(OUR APPROACH)`
5. `(VALUES)`
6. `(andbld Value Cycle)`
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

## Common CTA

English:

> Let's Build Together.

Main:

> あなたの挑戦を、次の価値へ。

Body:

> AI導入、Webシステム開発、業務改善、新規事業など、まずは実現したいことをお聞かせください。

Contact URLは `/contact/` を維持する。

## Global Navigation

- Before: `サービス`
- After: `事業内容`
- Link: `/services/`

現行テーマは `wp_nav_menu()` を使うため、メニュー文言はWordPress管理画面側の作業になる可能性が高い。テーマへ不要なハードコードは追加しない。

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
