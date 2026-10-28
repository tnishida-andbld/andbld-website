# Version

## andbld AI Development OS

- Version: **v0.9**
- Updated: 2026-10-28

番号は既存履歴（v0.2〜v0.8）の次号である。新しい版数規則は導入しない。

### v0.9 変更概要

- I-0007 AI Web Operations基盤構築の中間記録。D-0017
- 独立した非公開運用リポジトリを採用。サイトテーマとデプロイは変更なし
- 3サービスの読み取り接続、固定根拠によるAI提案PoC、下書きHuman Reviewを確認
- 日次取得を有効化。手動取得と90日artifact保存は成功。初回schedule実行は未確認
- Current Issue: I-0007（In Progress）。全体完了・週次提案自動化を意味しない
- Next Issue: Human確認待ち

### v0.9 追記（2026-10-28）

- D-0018: 投稿318のDevelopment確認と、別途承認後のHumanによるProduction保存を記録
- L-0009 / `docs/ARTICLE_EDITING.md`: 元記事の意図、100文字以内のポイント、装飾・改行維持、全文プレビュー、対象記事だけの反映手順
- 公開後の確認範囲と未検証事項を明記。リンク切れ自動化・28日後の効果測定は未実施
- v0.9の中間記録への追記。I-0007はIn Progressのまま

### v0.9 読み取り調査の追記（2026-10-28）

- PR #17〜#22によるDevelopment記事の読み取り調査。run `40677284332`で投稿318の識別と本文サイズ・ハッシュ取得に成功
- 調査用PHPは8.3.36。WP-CLI実動作、バックアップ作成・復元、SSH権限分離は未検証
- `docs/ARTICLE_EDITING.md`へバックアップ・復元PoC案を追加。未承認・未実装であり、記事の自動更新や本番更新権限を追加しない
- v0.9を維持。I-0007はIn Progressのまま

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
| v0.9 | 2026-10-28 | I-0007中間記録。D-0017。日次取得有効化・手動検証済み、定期初回確認待ち |
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
