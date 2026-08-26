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

新セッション（ChatGPT / Cursor / Claude Code / Devin 等）は、会話履歴ではなく `docs/HANDOFF.md` から現在地を復元する。GitHub を参照できる場合はリポジトリ上のファイルを取得し、できない場合は Human に添付を依頼する（取得前は推測も実装もしない）。詳細は D-0008。

現在利用中：

- ChatGPT
- Cursor

導入予定：

- Claude Code
- Devin

詳細は

docs/AI_DEVELOPMENT_RULES.md

を参照してください。

## Local Development

ローカルでは Git 管理テーマを Single Source of Truth とします。

XAMPP が実行するテーマは、Git working tree 上のテーマへの Junction です。

詳細は `docs/999_DECISIONS.md` の D-0006 を参照してください。

### Repository

Git working tree:

```
C:\Users\nishi\OneDrive\Documents\GitHub\andbld-website
```

開発対象テーマ:

```
wordpress/wp-content/themes/andbld/
```

Cursor は repository root（Git working tree）を開きます。

### XAMPP

WordPress:

```
C:\xampp\htdocs\andbld-web
```

Local URL:

```
http://localhost/andbld-web/
```

localhost は Human Review 用の実行環境です。

### Junction

XAMPP側:

```
C:\xampp\htdocs\andbld-web\wp-content\themes\andbld
```

↓ Junction

Git管理テーマ:

```
C:\Users\nishi\OneDrive\Documents\GitHub\andbld-website\wordpress\wp-content\themes\andbld
```

Junction作成例:

```bat
mklink /J "C:\xampp\htdocs\andbld-web\wp-content\themes\andbld" "C:\Users\nishi\OneDrive\Documents\GitHub\andbld-website\wordpress\wp-content\themes\andbld"
```

既に Junction が存在する場合は再作成しません。

### Development Rule

- テーマの編集は必ず Git working tree 側で行う
- XAMPP 側テーマへ手動コピーしない
- XAMPP 側 `themes\andbld` は Junction として扱う
- WordPress Core / DB / uploads / `wp-config.php` は Git 管理しない
- Cursor は repository root を開く
- Claude Code（導入後）も同じ Git working tree を参照する
- Devin（導入後）は GitHub repository を参照する
- localhost は Human Review 用
- Junction のリンク先を誤って削除しない
- `andbld.bak-20260821` はバックアップであり、削除は人間判断
- OneDrive 配下運用は現状維持だが、問題が出た場合は別 Issue で見直す

### Setup Verification

セットアップ後、以下を確認します。

- Junction が存在する
- Junction 先が Git テーマである
- localhost が正常表示される
- Git 側変更が localhost へ即時反映される
- Git status が意図しない差分を持っていない

## Development Deploy

Development へのテーマ反映は GitHub Actions の手動実行です。

- `main` へテーマ変更を Merge したあと、Actions の Deploy to Development を `workflow_dispatch` で実行する
- `mode` の初期値は `dry-run`。実反映は `deploy`
- Production はこのフローの対象外

詳細は `docs/999_DECISIONS.md` の D-0007 を参照してください。
