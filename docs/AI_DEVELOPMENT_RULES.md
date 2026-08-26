# Andbld AI Development Standard

## 基本方針

このプロジェクトは
保守性
SEO
表示速度
可読性
を最優先とします。

AIは独断で仕様変更を行わないこと。

必ず既存デザインとの整合性を保つ。

---

## 新セッション

新しい AI は次の順で進める。

1. `docs/HANDOFF.md` を読む
2. 現在地を Human へ報告する
3. Human 確認後、指定 Issue の関連ドキュメントを読む
4. 作業を開始する

HANDOFF を読んだだけで次 Issue を選んだり実装したりしない。

---

## WordPress

WordPress本体は編集禁止。

テーマ内のみ変更可能。

プラグイン追加は禁止。

functions.php変更時は影響範囲を書く。

---

## PHP

PHP8.x対応

Fatal Error禁止

Warningが出ないコード

WordPress Coding Standardsを優先

---

## CSS

命名規則

BEM推奨

!important禁止

固定pxを多用しない

---

## JavaScript

Vanilla JS優先

jQuery追加禁止

---

## SEO

title変更禁止

meta変更時は理由を書く

構造化データは維持

---

## Pull Request

変更内容

影響範囲

スクリーンショット

確認項目

を書くこと。