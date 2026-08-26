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
