# HANDOFF — andbld AI Development OS

> 現在地のスナップショット／索引。詳細は複製しない。
> 更新日: 2026-10-28 ／ OS Version: **v0.9**（履歴は `docs/VERSION.md`）

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
| OS Version | v0.9 |
| 完了 | I-0001 / I-0002 / I-0003 / I-0003.5 / I-0004 / I-0005 / I-0006 |
| Current Issue | I-0007 AI Web Operations基盤構築：進行中。D-0017 / D-0018 |
| Next Issue | 未決定。I-0007の残作業を優先。次IssueはHuman確認待ち |
| テーマ Version | 1.0.0（`style.css` のヘッダ。enqueue のクエリは D-0012 で `filemtime()`） |

## 3. Issue スナップショット

| ID | 内容 | Status | 詳細 |
|----|------|--------|------|
| I-0001 | TOP BLOG 横スクロール | Done | L-0001〜L-0003, D-0005 |
| I-0002 | Git × XAMPP Junction | Done | D-0006, L-0004, P-0001 |
| I-0003 | Development 手動デプロイ | Done | D-0007, L-0005, L-0006, P-0002 |
| I-0003.5 | 引き継ぎ基盤（HANDOFF） | Done | このファイル, D-0008, L-0007 |
| I-0004 | サイトコンテンツ更新 | Done。PR #10 MERGED。Production 反映・UAT・最終回帰 PASS。Human Acceptance 済み | D-0009〜D-0014。計画と仕様 |
| I-0005 | カスタマーハラスメント方針の Git 正式取り込み | Done。PR #12 MERGED（`886db05`、2026-10-26 16:57:29 JST）。テーマ 4 ファイル。Development / Local 反映は I-0006 | D-0015 |
| I-0006 | WordPress 環境再同期 | Done。Production 由来 DB・uploads を Development / Local へ同期。テーマは `main`。Deploy run `40625104615`。方針ページ 3 環境確認 | D-0016 |
| I-0007 | AI Web Operations基盤構築 | In Progress。3サービス接続・提案PoC・下書きHuman Review・日次取得有効化済み。定期実行の初回成功は未確認 | D-0017 / D-0018、運用リポジトリREADME |

P-0002 等を「次に必ず実施する Issue」としない。次は Human が決める。

## 4. Pending / 今後の候補

実施順は Human が決める。AI は選ばない。

| ID / 項目 | Status | 詳細 |
|-----------|--------|------|
| P-0002 `main` push 自動デプロイ | Open | `docs/998_LESSONS_LEARNED.md` |
| `css/layout.css` Production 専用差分 | 未決定 | ブログ個別ページのリンク色。I-0005 / I-0006 対象外。D-0015 / D-0016 |
| Production 自動デプロイ | 未着手 | D-0007 |
| SSH connectivity test のリトライ | 未着手 | L-0005 |
| Development backup の prune | 後続 | workflow コメント |
| テーマ Requires PHP / Tested up to | TODO | `docs/VERSION.md` |
| リポジトリ版数・リリース手順 | TODO | `docs/VERSION.md` |
| Local `cron` オプション残差 | Open | Yoast エントリが残る。実行時は抑止済み。整理は未実施。D-0016 |
| 外部連携プラグインの追加抑止 | Open | leadin / AIOS / WP Super Cache は実行時除外済み。メール実送信テストは未実施。D-0016 |
| `.gitignore` 補強 | Open | `*.wpress` と `wordpress/wp-content/plugins/` は未追加。今回の混入はなし。D-0016 |
| 旧 DB・旧バックアップの整理 | Open | sidecar / isolate 切替後の旧 DB と作業前ダンプは残置。削除は未決定。D-0016 |
| ナビ「サービス」→「事業内容」 | 未実施。変更先は維持。時期は未決定 | D-0009, D-0014 |
| `/services/` の H1・ページタイトル | 未決定 | D-0009, D-0014 |
| TOP の SEOタイトル | 未決定。無承認では変えない | D-0009, D-0014 |
| サイトマップの旧4URL除外 | 未実施。方法と時期は未決定 | D-0009, D-0011, D-0014 |
| ログイン済み旧ページプレビュー確認 | 未了 | D-0011 |
| 残りの CSS `@import` のキャッシュ管理 | 未決定 | D-0012 |
| Xserver 自動バックアップの完了確認 | 未了。完了待ちのため完了扱いしない | D-0014 |
| バックアップ復元テスト | 未実施 | D-0014 |

P-0001 は Resolved。本文は `docs/998_LESSONS_LEARNED.md`。

I-0006 の切り戻し概要（詳細は D-0016。値と絶対パスは書かない）:

- Development テーマ: `andbld.bak-20261028031013` を戻す
- Development / Local DB: `wp-config.php` の接続先を切替前の DB に戻す。旧 DB は残置
- Production は対象外

### I-0007の記事改善実績

- 2026-10-28、投稿318をDevelopmentでHuman Review後、別途本番承認・バックアップ・プレビュー確認を経てHumanがProductionへ保存。詳細と確認限界はD-0018
- 編集・反映手順: `docs/ARTICLE_EDITING.md`。教訓: L-0009
- 記事本文はWordPress投稿データ。テーマデプロイでは反映されない。Localの同記事は今回未更新
- リンク切れ検知・修正案の自動化は検討段階。監視・自動修正は未実装

### I-0007の残作業

- 初回のschedule実行でGoogle・Clarityの取得とartifact保存を確認（手動成功とは区別）
- 日次異常検知、未起動検知・通知、週次提案、月次効果測定は未実装。I-0007の完了範囲と後続Issueへの切り分けはHuman判断
- 運用リポジトリの手順書・キー更新手順のレビュー
- 公開記事の28日後評価は未実施。効果測定の自動化・予約は未設定
- I-0007全体の最終Acceptanceは未実施

## 5. 環境の運用状態

- Local: Git テーマが SoT。XAMPP は Junction。手順は `README.md`。参照 DB は I-0006 isolate。Production 由来コンテンツ同期済み。旧 Local DB は残置
- Development: GitHub Actions + rsync over SSH。正式運用は `workflow_dispatch` 手動。`mode` 初期値 `dry-run`。deploy 後も Human Review 必須。`main` push 自動デプロイは未実施（P-0002）。Environment `development` の Deployment branches は `main` のみ。参照 DB は I-0006 sidecar。I-0005 テーマは run `40625104615` で反映済み。旧 Development DB は残置
- Production: 自動デプロイなし。I-0004 は 2026-10-26 に FileZilla でテーマ 10 ファイルを個別反映（D-0014）。I-0005 テーマ 4 ファイルは Production 先行公開済み。I-0006 では Production の DB・ファイルを変更していない

- Web Operations: 非公開の `tnishida-andbld/andbld-web-operations`。毎日09:17 JSTに読み取り集計、artifactは90日。AI提案は手動。Production更新権限なし。詳細は同リポジトリREADME

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
- D-0015 I-0005 の Production 先行実装を Git へ正式取り込み。環境再同期は I-0006 へ分離
- D-0016 I-0006 WordPress 環境再同期完了。Human 承認。Done
- D-0017 I-0007の段階的構築と中間到達点。進行中
- D-0018 投稿318のHumanによるDevelopment・Production反映と検証範囲

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
- L-0009 記事の意図・装飾・改行を維持し、全文を実環境で確認

## 8. 現時点の方針

- 実装前に目的を定義する
- 独断で仕様変更しない
- コード変更はテーマ内のみ。WP 本体・プラグイン追加は禁止。別途承認された記事本文の手動更新はD-0018 / `docs/ARTICLE_EDITING.md`を参照
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
- `docs/ARTICLE_EDITING.md`（承認済みの記事改善時）
- `README.md`（Local / デプロイ操作時）
- `.github/workflows/deploy-development.yml`（デプロイ改修時）

Cursor 固有: `.cursor/rules/project.md`（入口の補足。SoT ではない）

## 11. このファイルに書いてはいけないもの

SSH ホスト / ユーザー / ポート / 秘密鍵 / known_hosts 実体 /
サーバー絶対パス / Basic 認証 / DB / `.env` / ローカル PC の絶対パス

値は GitHub Environment Secrets のみ。名前が必要なら workflow を見る。
