# Version

## andbld AI Development OS

- Version: **v0.8**
- Updated: 2026-10-28

番号は既存履歴（v0.2〜v0.7）の次号である。新しい版数規則は導入しない。

### v0.8 変更概要

- I-0006 WordPress 環境再同期完了。D-0016
- Production 由来の DB・uploads を Development / Local へ同期
- Development は sidecar DB、Local は isolate DB。既存 DB は残置
- GitHub `main` をテーマ SoT として維持。Local Junction 維持
- Development テーマ Deploy: Actions run `40625104615` / SHA `3f8525f95bcb8262d24993fd81b0c900db7dcb34`
- `/customer-harassment-policy/` を 3 環境で表示確認
- Current Issue なし
- Next Issue は未決定。Human 確認待ち

### v0.7 変更概要

- I-0005 の Git 正式取り込み完了（PR #12 MERGED）
- Merge SHA: `886db0503037a23a015209d47a78da423f37ce95`
- D-0015 追加。テーマ 4 ファイルを `main` へ取り込み
- Development / Local の環境再同期は未実施
- Current Issue なし
- Next Issue は未決定（I-0006 の WordPress 環境再同期が候補）

### v0.6 変更概要

- I-0004 Production リリース完了
- Human Acceptance 承認
- D-0014 追加。I-0004 を Done
- Current Issue なし
- Next Issue は未決定（I-0005 の Git 正式取り込みと Development 同期が候補）

### v0.5 変更概要

- I-0003.5 引き継ぎ基盤完了（`docs/HANDOFF.md`）
- 新セッションは HANDOFF → 現在地報告 → Human 確認後に作業
- D-0008 / L-0007 追加
- Current Issue なし。Next Issue は Human 確認待ち
- Human Review: HANDOFF 到達経路を追加（L-0008）

### v0.4 変更概要

- I-0003 GitHub → Development 手動デプロイ完了
- GitHub Actions + rsync over SSH（`workflow_dispatch` のみ）
- Development を Git テーマの Single Source of Truth として同期
- D-0007 / L-0005 / L-0006 追加
- P-0002 を Open として記録（`main` push 自動デプロイは未実施）
- Human Review まで完了し I-0003 を Done

### v0.3 変更概要

- Git × XAMPP JunctionによるLocal Development一本化
- Git working treeをSingle Source of Truth化
- Local Setup手順をREADMEへ追加
- LF統一ルール追加（`.gitattributes`）
- P-0001解消
- I-0002実施
- D-0006 / L-0004 追加

### v0.2 変更概要

- 初回実案件 I-0001 を通じた開発フロー検証
- Human Review / Acceptanceルール追加（D-0005）
- Lessons Learned運用開始（L-0001 / L-0002 / L-0003）
- Decision Log更新
- I-0001 Production deployment completed / L-0003 added

### 履歴

| Version | Date | Summary |
|---------|------|---------|
| v0.8 | 2026-10-28 | I-0006 WordPress 環境再同期完了。D-0016。Dev sidecar / Local isolate。テーマ Deploy run 40625104615 |
| v0.7 | 2026-10-26 | I-0005 Git 正式取り込み完了。PR #12。D-0015。環境再同期は未実施 |
| v0.6 | 2026-10-26 | I-0004 Production 完了。Human Acceptance。D-0014。Current Issue なし |
| v0.5 | 2026-08-26 | I-0003.5 引き継ぎ基盤。HANDOFF / D-0008 / L-0007 / L-0008。Current Issue なし |
| v0.4 | 2026-08-26 | I-0003 Development 手動デプロイ完了。GHA + rsync。D-0007 / L-0005 / L-0006。P-0002 Open |
| v0.3 | 2026-08-21 | Git × XAMPP Junction一本化。Single Source of Truth化。Local Setup / LF統一。P-0001解消（I-0002） |
| v0.2 | 2026-08-21 | I-0001 Production deployment completed / L-0003 added。Human Review必須化。Lessons Learned開始 |
| v0.1 | 2026-07-10 | Philosophy / 初期Decision策定 |

## テーマ

- Theme Name: andbld
- Version: 1.0.0（`wordpress/wp-content/themes/andbld/style.css` 記載）
- Requires PHP: TODO（README 上は PHP8.x。style.css 記載値との整理は未実施）
- Tested up to: TODO

## 環境

| 環境 | 内容 |
|------|------|
| Local | XAMPP |
| Development | dev-20260601.andbld.co.jp |
| Production | andbld.co.jp |

## TODO

- リポジトリ全体のバージョニング方針
- リリース手順とバージョン更新ルール
- WordPress 本体の対象バージョン
