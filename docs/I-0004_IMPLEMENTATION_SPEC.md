# I-0004 Implementation Specification

## Status

Approved for implementation planning. Site code implementation has not started.

## Purpose

アンドビルドのMVVおよび事業内容のアップデートに伴い、コーポレートサイトの主要コンテンツを刷新する。

従来の「AI×RPAによる業務効率化を中心とした会社」という見え方から、次の企業像へ更新する。

> 挑戦を、実装する。

基本メッセージ:

- 事業を理解する。
- 技術で実現する。
- 人とAIをつなぐ。
- 挑戦を価値へ変える。

## Source Material

Humanから共有された以下の資料をコンテンツSoTとして設計した。

- アンドビルド株式会社 MVVアップデート版
- 事業概要

実装時に資料にない情報を推測で追加しない。

## Content Principles

### Japanese first

基本的な情報・説明は日本語中心とする。

- `andbld` は本文では原則「アンドビルド」または「私たち」
- `Technology` は本文では「技術領域」
- `Business` は本文では「事業領域」
- グローバルナビの `サービス` は `事業内容` へ変更

既存デザインとの整合のため、セクションラベル等の英語は使用可能。

例:

- `(WHO WE ARE)`
- `(SERVICE)`
- `(OUR APPROACH)`
- `(PHILOSOPHY)`
- `(VISION)`
- `(MISSION)`
- `(VALUES)`
- `(TECHNOLOGY)`
- `(BUSINESS)`
- `(OUR BUSINESS)`
- `BLOG`
- `NEWS`
- `Let's Build Together.`

### Corporate site, not LP

TOP / ABOUT / 事業内容ページは、過度な営業LP構成にしない。

- 「選ばれる理由」等の一般的な営業見出しを多用しない
- TOPですべてを説明しない
- 詳細は下層ページへ誘導する
- 既存サイトのシンプルな情報設計と英語セクションラベルを活かす

## Scope

### Update

- TOP
- ABOUT
- `/services/`（表示上は「事業内容」）
- グローバルナビ: `サービス` → `事業内容`
- 共通CTAコピー
- ABOUT / OUTLINE の事業内容

### Retire as current services

- BizScan
- CreativeForce
- Guardian
- NextGen .Lab

旧4サービスの個別ページテンプレートは、将来OUR BUSINESS等の詳細ページへ転用できるよう、現時点では削除しない。

旧4URLの公開終了方法はSEO調査後にHumanが最終判断する。

### Keep

- CAREERS
- CONTACT
- フッターの基本構造
- BLOG機能
- NEWS機能
- GLOSSARY
- EBOOK
- 問い合わせ機能
- WordPress本体
- プラグイン
- 旧4サービス以外のURL構造
- title / SEO meta（別途明示承認がない限り変更しない）

---

# TOP

## Structure

1. FV
2. `(WHO WE ARE)`
3. `(SERVICE)`
4. `(OUR APPROACH)`
5. BLOG
6. NEWS
7. 共通CTA

## FV

### Main

挑戦を、実装する。

### Sub

事業を理解し、技術で実現し、人とAIをつなぐ。

### Body

私たちは、AI・Webシステム・業務自動化などの技術と、事業を運営する実践知を掛け合わせ、構想から実装、成長まで一貫して伴走します。

## WHO WE ARE

### Label

`(WHO WE ARE)`

### Heading

事業と技術、その両方を実践する。

### Body

私たちは、開発だけを行う会社でも、事業を考えるだけの会社でもありません。

事業の目的を理解し、必要な技術を選び、実際に動く仕組みとして形にする。
そして、自らの事業で得た経験を、お客様の新たな挑戦へ還元していきます。

### Link

ABOUT US → ABOUT

## SERVICE

### Label

`(SERVICE)`

### Heading

事業を前に進めるために、必要な方法を。

### Body

AI、Webシステム、業務自動化、コンサルティング。
私たちは、技術導入そのものではなく、事業の目的から最適な方法を考えます。

### Summary

#### 技術領域

AI・Web・業務自動化を通じて、企業の挑戦を実装します。

#### 事業領域

事業づくりの実践知を活かし、構想から成長まで伴走します。

TOPでは個別領域をすべて列挙しない。

### Link

事業内容 → `/services/`

## OUR APPROACH

### Label

`(OUR APPROACH)`

### Heading

技術からではなく、事業から考える。

### Body

私たちが最初に考えるのは、「何をつくるか」ではなく、「何を実現したいか」です。

事業を理解し、本当に必要な方法を選び、構想だけで終わらせず実装まで。
人とAI、それぞれの強みを活かしながら、変化が現場に根づくところまで伴走します。

カード型の「選ばれる理由」にはしない。

## BLOG / NEWS

既存機能・基本構成を維持する。

I-0001で確定したBLOG横スクロールUIを破壊しない。

---

# ABOUT

## Structure

1. ABOUT / 私たちについて
2. `(PHILOSOPHY)`
3. `(VISION)`
4. `(MISSION)`
5. `(OUR APPROACH)`
6. `(VALUES)`
7. `(andbld Value Cycle)`
8. `(OUTLINE)`
9. `(ACCESS)`

## PHILOSOPHY

### Heading

テクノロジーで、社会に新しい余白を。

### Body

テクノロジーは、人の可能性を広げるためにある。

私たちはAIをはじめとする技術を活用し、業務の効率化や仕組み化を進めることで、人と企業に新しい「余白」を生み出します。

そして、その余白が新しい挑戦や創造につながる社会をつくります。

## VISION

### Heading

生まれた余白を、挑戦へ。

### Body

効率化によって生まれた時間や余力を、ただの余白で終わらせない。

新しい事業、新しい働き方、新しいアイデア。
その余白を、人や企業が次の一歩を踏み出すための挑戦へ変えていきます。

## MISSION

### Heading

AIと人の共創で、
余白を挑戦へ、挑戦を価値へ変える。

### Body

AIには、業務を効率化し、仕組みを変える力があります。
人には、考え、創造し、挑戦する力があります。

私たちはAIと人、それぞれの強みを活かしながら、企業や人の挑戦を実装し、新しい価値へ変えていきます。

## OUR APPROACH

### Heading

挑戦を、実装する。

### Key Message

事業を理解する。
技術で実現する。
人とAIをつなぐ。
挑戦を価値へ変える。

### Body

私たちは、開発だけを行う会社でも、事業を考えるだけの会社でもありません。

経営や事業の目的を理解し、必要な技術を選び、人・組織・業務・AIをつなぎながら、構想を実際に動く仕組みへ変えていきます。

そして、私たち自身も事業に挑戦し続けます。
そこで得た経験や知見を、お客様の新しい挑戦へ還元していきます。

## VALUES

### Heading

「&」から、価値をつくる。

### Items

- `& Think Beyond` / 常識の外側から考える。
- `& Embrace AI` / AIを前提に考える。
- `& Challenge First` / まず挑戦する。
- `& Build Together` / 一緒につくる。
- `& Be Honest` / 誠実である。
- `& Create Impact` / 価値を生み出す。
- `& Human First` / 人を中心に考える。
- `& Grow Together` / 仲間と成長する。

過度にインタラクティブにせず、シンプルな一覧表現を基本とする。

## VALUE CYCLE

### Label

`(andbld Value Cycle)`

### Heading

余白から、次の挑戦へ。

### Flow

余白 → 挑戦 → 価値創出 → 成長 → 新しい余白

### Body

テクノロジーによって余白を生み、その余白を新しい挑戦へ。
挑戦から価値を生み、成長へつなげる。

そして、その成長がまた新しい余白を生み出す。

私たちは、この循環を社会に広げていきます。

## OUTLINE

会社概要の基本情報は維持する。

### 事業内容

AI・Webシステム開発、業務自動化、IT・AIコンサルティング、新規事業支援、自社事業の企画・運営

旧4サービスを列挙する「提供サービス」は削除する。

## ACCESS

既存構成を基本維持する。

---

# 事業内容 `/services/`

## Page title

表示上は「事業内容」。URL `/services/` は維持する。

## Structure

1. INTRODUCTION
2. `(TECHNOLOGY)` / 技術領域
3. `(BUSINESS)` / 事業領域
4. `(OUR BUSINESS)`
5. `(OUR APPROACH)`
6. 共通CTA

## INTRODUCTION

### Heading

事業を前に進めるために、必要な方法を。

### Body

私たちは、技術を導入すること自体を目的にはしません。

事業や経営の課題を理解し、その実現に必要なAI、Webシステム、業務自動化、コンサルティングなどを組み合わせ、構想から実装、運用・改善まで伴走します。

## TECHNOLOGY / 技術領域

### Heading

AI・Web・業務自動化で、企業の挑戦を実装する。

### Areas

1. AI開発・導入支援
   - AIを、実際の業務で使える仕組みへ。
2. Webシステム開発
   - 事業を支える、Webの仕組みをつくる。
3. RPA・業務自動化
   - 繰り返す仕事を、仕組みに変える。
4. AIエージェント開発
   - AIが考え、動く業務環境へ。
5. CMS構築
   - 更新しやすく、成長できるWeb基盤を。
6. API・システム連携
   - 分かれたシステムとデータを、つなぐ。
7. 保守・運用支援
   - つくった後も、育て続ける。

## BUSINESS / 事業領域

### Heading

事業を考え、つくり、育てる。

### Client-facing areas

1. IT・AIコンサルティング
2. DX推進支援
3. AI活用戦略
4. 新規事業支援

それぞれに簡潔な説明を付与する。

## OUR BUSINESS

### Heading

自ら事業をつくる。

### Body

私たちは、お客様の事業を支援するだけでなく、自らも事業づくりに挑戦しています。

EC、海外事業、商品開発などを通じて得た実践知を、コンサルティングやシステム開発、新規事業支援へ還元しています。

### Current categories

- EC事業
- 海外事業
- 商品開発

現時点では詳細個別ページを新設しない。
内容が具体化した段階で、旧サービス個別ページのテンプレート構造を転用候補とする。

## OUR APPROACH

### Heading

技術からではなく、事業から考える。

### Flow

事業を理解する
↓
課題を整理する
↓
必要な方法を考える
↓
設計・実装する
↓
運用・改善する

### Body

「AIを導入したい」「システムをつくりたい」から始めるのではなく、その先で何を実現したいのかを考える。

事業や業務を理解したうえで、必要な技術と方法を選び、実装し、現場で使われる仕組みへ育てていきます。

---

# Common CTA

### English

Let's Build Together.

### Main

あなたの挑戦を、次の価値へ。

### Body

AI導入、Webシステム開発、業務改善、新規事業など、まずは実現したいことをお聞かせください。

既存CTAの構造を活かし、コピーを更新する。

---

# Global Navigation

グローバルナビの表示名を変更する。

- Before: サービス
- After: 事業内容
- URL: `/services/` を維持

現行テーマは `wp_nav_menu()` を使用しているため、メニュー文言がWordPress管理画面側で管理されている可能性がある。
実装時に実体を確認し、テーマへ不要なハードコードを追加しない。

---

# Legacy Service URLs

対象:

- `/services/bizscan/`
- `/services/creativeforce/`
- `/services/guardian/`
- `/services/nextgenlab/`

Human Decision:

- 旧4サービスは現行サービスとして廃止する。
- ページテンプレートは将来の再利用候補として残す。
- URL処理は現状調査後に決める。
- AIが独断で削除・301・410等を決定しない。

調査項目:

- 現在の公開状態
- テーマ内の内部リンク
- WordPressメニュー等の内部リンク
- 検索エンジン露出の確認
- Search Consoleのクリック / 表示 / インデックス状況（必要な場合Humanへ確認）
- 被リンク（必要な場合Humanへ確認または外部調査）

---

# Design Direction

全面デザインリニューアルではなく、既存デザインシステムを活かしたコンテンツ刷新とする。

維持:

- 基本タイポグラフィ
- 既存レイアウト思想
- 英語セクションラベル
- 余白感
- BLOG UI
- Header / Footer基本構造
- レスポンシブ思想

新規設計が主に必要:

- TOP SERVICEの技術領域 / 事業領域の簡易表示
- TOP / ABOUT / SERVICE のOUR APPROACH
- ABOUT VALUES
- ABOUT Value Cycle
- SERVICE OUR BUSINESS

---

# Implementation Candidates

現時点で確認済みの主要対象:

- `wordpress/wp-content/themes/andbld/page-frontpage.php`
- `wordpress/wp-content/themes/andbld/template-parts/inc/about-page.php`
- `wordpress/wp-content/themes/andbld/template-parts/inc/services-page.php`
- `wordpress/wp-content/themes/andbld/template-parts/content-page.php`
- `wordpress/wp-content/themes/andbld/section-parts/cta-block1.php`
- 各ページ関連CSS
- 必要な場合のみ既存JavaScript

旧4サービス個別テンプレートは削除しない。

実装対象ファイル一覧は実装開始前のコード調査で確定する。

---

# Acceptance Criteria

## Content

- TOPが新しい企業ポジショニングを表現している
- ABOUTが新MVVと一致している
- 事業内容ページが新しい事業構成と一致している
- 旧4サービスが現行サービスとして主要導線に表示されていない
- グローバルナビが「事業内容」表記になっている
- 日本語中心の表現ルールが守られている
- 対象3ページから旧AI×RPA中心の企業説明が適切に除去されている
- 共通CTAが新コピーへ更新されている

## UI / Human Review

- PC実ブラウザ
- スマートフォン表示
- 操作性
- 既存機能への影響
- Console Error
- 文字量によるレイアウト崩れなし
- 下層ページへのリンク正常
- BLOG横スクロールUX維持
- Header / Footer正常

## Regression

- BLOG正常
- NEWS正常
- CAREERS正常
- CONTACT正常
- 問い合わせ機能正常
- GLOSSARY / EBOOKに意図しない影響なし

AIの実装・自己検証のみではDoneとしない。Human Acceptanceを必須とする。

---

# Implementation Gate

この仕様書の作成時点ではサイトコードを変更しない。

次の順で進める。

1. 実装前調査
2. 変更対象ファイルを確定
3. 旧4サービスURL処理に必要な追加情報を確認
4. 実装計画をHumanへ提示
5. Human確認
6. 実装開始
7. Local Human Review
8. PR / Development deploy
9. Development Human Review
10. Productionは別途Human確認のうえ反映
