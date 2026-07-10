# andbld Corporate Website

アンドビルド株式会社のコーポレートサイトです。

## リポジトリの範囲

このリポジトリは WordPress 本体を管理するものではありません。

管理対象:

- andbld カスタムテーマ（`wordpress/wp-content/themes/andbld/`）
- 開発ドキュメント（`docs/`）
- AI 開発ルール（`docs/AI_DEVELOPMENT_RULES.md`、`.cursor/rules/`）

管理対象外:

- WordPress 本体（`wp-admin/`、`wp-includes/` 等）
- データベース
- `uploads`
- 秘密情報（`wp-config.php`、`.env` 等）

## 実際の開発対象パス

```
wordpress/wp-content/themes/andbld/
```

テーマ内のみ変更可能です。詳細は `docs/AI_DEVELOPMENT_RULES.md` を参照してください。

## 技術構成

- WordPress
- PHP8.x
- HTML5
- CSS3
- JavaScript
- GitHub
- XAMPP
- Xserver

## 環境

Local
XAMPP

↓

Development
dev-20260601.andbld.co.jp

↓

Production
andbld.co.jp

## AI Development

現在利用中：

- ChatGPT
- Cursor

導入予定：

- Claude Code
- Devin

詳細は

docs/AI_DEVELOPMENT_RULES.md

を参照してください。
