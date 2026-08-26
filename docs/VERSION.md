# Version

## andbld AI Development OS

- Version: **v0.4**
- Updated: 2026-08-26

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
