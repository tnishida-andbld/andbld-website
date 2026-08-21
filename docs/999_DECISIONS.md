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
