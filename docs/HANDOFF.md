# HANDOFF — andbld AI Development OS

> 現在地のスナップショット／索引。詳細は複製しない。
> 更新日: 2026-08-26 ／ OS Version: **v0.5**（履歴は `docs/VERSION.md`）

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
| OS Version | v0.5 |
| 完了 | I-0001 / I-0002 / I-0003 / I-0003.5 |
| Current Issue | なし |
| Next Issue | 未決定。Human 確認待ち |
| テーマ Version | 1.0.0（`style.css`。OS Version とは別） |

## 3. Issue スナップショット

| ID | 内容 | Status | 詳細 |
|----|------|--------|------|
| I-0001 | TOP BLOG 横スクロール | Done | L-0001〜L-0003, D-0005 |
| I-0002 | Git × XAMPP Junction | Done | D-0006, L-0004, P-0001 |
| I-0003 | Development 手動デプロイ | Done | D-0007, L-0005, L-0006, P-0002 |
| I-0003.5 | 引き継ぎ基盤（HANDOFF） | Done | このファイル, D-0008, L-0007 |

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

P-0001 は Resolved。本文は `docs/998_LESSONS_LEARNED.md`。

## 5. 環境の運用状態

- Local: Git テーマが SoT。XAMPP は Junction。手順は `README.md`
- Development: GitHub Actions + rsync over SSH。正式運用は `workflow_dispatch` 手動。`mode` 初期値 `dry-run`。deploy 後も Human Review 必須。`main` push 自動デプロイは未実施（P-0002）
- Production: 自動デプロイなし。最終の本番反映は I-0001 の手動アップロード。一致確認は Human 事項

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
