# HANDOFF — andbld AI Development OS

> 現在地のスナップショット／索引。詳細は複製しない。
> 更新日: 2026-10-26 ／ OS Version: **v0.7**（履歴は `docs/VERSION.md`）

## 0. 新セッションの約束（必須）

新しい AI は、このファイルを読んだだけで次 Issue を選んだり実装したりしない。

1. このファイルを読む
2. 現在地を Human へ報告する
3. Human の確認を待つ
4. 指定された Issue の関連ドキュメントだけを読む
5. そのあと作業を開始する

報告すること: OS Version / 完了済み / 進行中 / Pending / Dev・Prod の運用状態 / Next Issue は Human 確認待ちであること / これから読む D・L・Rules

不明点は推測せず提案する。

### このファイルの取得方法

- GitHub リポジトリを直接参照できる場合: GitHub 上の `docs/HANDOFF.md` を取得して読む
- GitHub へアクセスできない場合: Human に `docs/HANDOFF.md` の添付を依頼する
- 過去チャット履歴だけを根拠に現在地を推測しない
- HANDOFF を取得できるまでは実装しない

## 1. このプロジェクトは何か

アンドビルド株式会社のコーポレートサイト。
Git 管理はカスタムテーマ `wordpress/wp-content/themes/andbld/` と docs / AI ルール。
WordPress 本体・DB・uploads・秘密情報は管理外。

詳細: `README.md` / `docs/000_PHILOSOPHY.md` / D-0001 / D-0002

## 2. 現在地

| 項目 | 状態 |
|------|------|
| OS Version | v0.7 |
| 完了 | I-0001 / I-0002 / I-0003 / I-0003.5 / I-0004 / I-0005（Git 正式取り込みのみ） |
| Current Issue | なし。I-0005 の Git 取り込みは DONE（PR #12 MERGED。詳細は D-0015）。Development / Local への反映は未完了 |
| Next Issue | 未決定。Human 確認待ち。候補は I-0006（WordPress 環境再同期）。実装は開始しない |
| テーマ Version | 1.0.0（`style.css` のヘッダ。enqueue のクエリは D-0012 で `filemtime()`） |

## 3. Issue スナップショット

| ID | 内容 | Status | 詳細 |
|----|------|--------|------|
| I-0001 | TOP BLOG 横スクロール | Done | L-0001〜L-0003, D-0005 |
| I-0002 | Git × XAMPP Junction | Done | D-0006, L-0004, P-0001 |
| I-0003 | Development 手動デプロイ | Done | D-0007, L-0005, L-0006, P-0002 |
| I-0003.5 | 引き継ぎ基盤（HANDOFF） | Done | このファイル, D-0008, L-0007 |
| I-0004 | サイトコンテンツ更新 | Done。PR #10 MERGED。Production 反映・UAT・最終回帰 PASS。Human Acceptance 済み | D-0009〜D-0014。計画と仕様 |
| I-0005 | カスタマーハラスメント方針の Git 正式取り込み | Git 部分は Done。PR #12 MERGED（`886db05`、2026-10-26 16:57:29 JST）。テーマ 4 ファイル。Development / Local 未反映 | D-0015 |

P-0002 等を「次に必ず実施する Issue」としない。次は Human が決める。

## 4. Pending / 今後の候補

実施順は Human が決める。AI は選ばない。

| ID / 項目 | Status | 詳細 |
|-----------|--------|------|
| P-0002 `main` push 自動デプロイ | Open | `docs/998_LESSONS_LEARNED.md` |
| Production 自動デプロイ | 未着手 | D-0007 |
| SSH connectivity test のリトライ | 未着手 | L-0005 |
| Development backup の prune | 後続 | workflow コメント |
| テーマ Requires PHP / Tested up to | TODO | `docs/VERSION.md` |
| リポジトリ版数・リリース手順 | TODO | `docs/VERSION.md` |
| I-0006 WordPress 環境再同期 | 未着手。候補。Production を WP コンテンツ・DB・uploads の基準、GitHub `main` をテーマ SoT とする | D-0015 |
| I-0005 Development / Local 反映 | 未完了。Git 取り込み済み。テーマデプロイは I-0006 の DB 同期計画と調整 | D-0015 |
| ナビ「サービス」→「事業内容」 | 未実施。変更先は維持。時期は未決定 | D-0009, D-0014 |
| `/services/` の H1・ページタイトル | 未決定 | D-0009, D-0014 |
| TOP の SEOタイトル | 未決定。無承認では変えない | D-0009, D-0014 |
| サイトマップの旧4URL除外 | 未実施。方法と時期は未決定 | D-0009, D-0011, D-0014 |
| ログイン済み旧ページプレビュー確認 | 未了 | D-0011 |
| 残りの CSS `@import` のキャッシュ管理 | 未決定 | D-0012 |
| Xserver 自動バックアップの完了確認 | 未了。完了待ちのため完了扱いしない | D-0014 |
| バックアップ復元テスト | 未実施 | D-0014 |

P-0001 は Resolved。本文は `docs/998_LESSONS_LEARNED.md`。

I-0006 の実作業は開始しない。着手時の確認事項（詳細は D-0015）:

- Production を WP コンテンツ・DB・uploads の基準とする
- GitHub `main` をテーマソースの基準とする
- 同期前にバックアップと復元方法を確認する。復元試験は未実施
- URL 置換はシリアライズ対応を必須とする
- 環境固有の認証情報・設定を保持する
- メール送信・外部 API・Webhook・WP-Cron 等の副作用を防ぐ
- Development の検索エンジン非公開を確認する
- `css/layout.css` の Production 専用差分（ブログ個別リンク色）は別途判断
- 各環境で固定ページの存在と表示を確認する

## 5. 環境の運用状態

- Local: Git テーマが SoT。XAMPP は Junction。手順は `README.md`。I-0005 テーマは `main` にある。固定ページ・DB・uploads の Production 基準同期は未実施
- Development: GitHub Actions + rsync over SSH。正式運用は `workflow_dispatch` 手動。`mode` 初期値 `dry-run`。deploy 後も Human Review 必須。`main` push 自動デプロイは未実施（P-0002）。I-0004 の一時 inspect mode は削除済み。Environment `development` の Deployment branches は `main` のみ。I-0005 テーマの Development 反映は未実施。DB 同期は I-0006
- Production: 自動デプロイなし。I-0004 は 2026-10-26 に FileZilla でテーマ 10 ファイルを個別反映（D-0014）。I-0005 テーマ 4 ファイルは Production 先行公開済みで、PR #12 により Git `main` へ取り込み済み。今回の Production 再アップロードは行わない

詳細: D-0003 / D-0006 / D-0007 / `README.md`「Development Deploy」
操作の実体: `.github/workflows/deploy-development.yml`
接続情報の値は GitHub Environment Secrets のみ。名前が必要なら workflow を見る。このファイルには書かない。

## 6. Decision 索引

本文: `docs/999_DECISIONS.md`

- D-0001 名称
- D-0002 Git はテーマ + docs
- D-0003 3環境
- D-0004 AI 役割
- D-0005 Human Review 必須
- D-0006 Local SoT = Git テーマ
- D-0007 Development は GHA + rsync、手動 dispatch
- D-0008 新セッションの入口は HANDOFF
- D-0009 I-0004 ローカル6 Commitを Accept。当時の未実施リストは本文に残す
- D-0010 I-0004 の採用文言。旧CTA英語見出し等を更新
- D-0011 301は旧4パスのみ。派生URLは今回の対象外
- D-0012 I-0004 変更CSSの `filemtime()` 読み込み
- D-0013 I-0004 は実装・Development 反映・UAT PASS まで完了。当時 PR #10 は OPEN / Draft。Production は未承認
- D-0014 I-0004 Production リリース完了。Human Acceptance。Done
- D-0015 I-0005 の Production 先行実装を Git へ正式取り込み。環境再同期は I-0006

## 7. Lessons 索引

本文: `docs/998_LESSONS_LEARNED.md`

- L-0001 AI 完了 ≠ Done
- L-0002 操作できることと認識できることは別
- L-0003 デプロイ対象は PR 全体
- L-0004 ソースと実行を分離しない
- L-0005 短時間連続 SSH は失敗し得る
- L-0006 Smoke Test は認証込み。401 を破損と混同しない
- L-0007 チャット履歴は現在地の SoT にしない
- L-0008 ドキュメントの存在だけでなく、SoT への到達経路も必要

## 8. 現時点の方針

- 実装前に目的を定義する
- 独断で仕様変更しない
- テーマ内のみ変更。WP 本体・プラグイン追加は禁止
- Git テーマ = Local / Development の SoT
- Development 反映は手動 `workflow_dispatch`
- Production 自動デプロイを始めない
- Actions 成功だけでは Done にしない

詳細: `docs/000_PHILOSOPHY.md` / `docs/AI_DEVELOPMENT_RULES.md`

## 9. 新しい Issue の基本手順

1. Human が目的を定義する
2. 新セッションは HANDOFF を読み、現在地を報告する
3. 不明なら調査・設計のみ。ファイル変更しない
4. Human 確認後に、指定 Issue だけを進める
5. UI 変更は PC / SP / 操作性 / 既存影響 / Console を Human Review（D-0005）
6. 必要なら Decision / Lesson / Pending を更新する
7. このファイルの現在地を更新する
8. `docs/VERSION.md` を更新する
9. Merge。Secrets を Commit しない

## 10. 読み順

必須: このファイル → Human へ現在地報告 → 確認待ち

確認後、指定 Issue に応じて:

- `docs/999_DECISIONS.md`
- `docs/998_LESSONS_LEARNED.md`
- `docs/AI_DEVELOPMENT_RULES.md`
- `README.md`（Local / デプロイ操作時）
- `.github/workflows/deploy-development.yml`（デプロイ改修時）

Cursor 固有: `.cursor/rules/project.md`（入口の補足。SoT ではない）

## 11. このファイルに書いてはいけないもの

SSH ホスト / ユーザー / ポート / 秘密鍵 / known_hosts 実体 /
サーバー絶対パス / Basic 認証 / DB / `.env` / ローカル PC の絶対パス

値は GitHub Environment Secrets のみ。名前が必要なら workflow を見る。
