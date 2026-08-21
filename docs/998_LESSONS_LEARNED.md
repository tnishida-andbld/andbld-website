# andbld AI Development OS

# Lessons Learned

---

## L-0001

### Date

2026-08-21

### Related

I-0001（TOPページ BLOGセクション横スクロール改修）

### Lesson

AIの実装完了報告と、実際の要件達成は異なる。

### Context

AI上では横スクロール実装が完了していると報告されたが、実際のPCブラウザではユーザーが横スクロール可能であることを認識・操作しづらい状態だった。

### Takeaways

- AIの「実装完了」をそのままDoneとしない
- 実ブラウザで人間が最終確認する
- Definition of Doneはコード上の成立だけでなく、実際のUXまで確認する
- AIの自己検証とHuman Reviewを分離する

---

## L-0002

### Date

2026-08-21

### Related

I-0001（TOPページ BLOGセクション横スクロール改修）

### Lesson

機能が存在することと、ユーザーが認識できることは別問題である。

### Context

CSSによる横スクロール自体は実装されていたが、PCではスクロールバーを非表示にしていたため、ユーザーから見ると「右に続きがある」ことが分かりづらかった。

最終的に、右矢印UI・右端フェード・マウス操作を追加することで改善した。

### Takeaways

- 「操作できる」だけでなく「操作できるとユーザーに伝わる」ことを確認する
- PCとSPでは入力方法が異なるため、それぞれUX確認する
- UI変更のDoDには discoverability（操作可能性の認知）も含める

---

## L-0003

### Date

2026-08-21

### Related

I-0001（TOPページ BLOGセクション横スクロール改修）

### Lesson

デプロイ対象ファイルは「最後のCommitで変更されたファイル」ではなく、「PR全体で本番環境に反映される変更ファイル」を基準に確認する。

### Context

I-0001のdev環境への反映時、Merge Blocker解消の最後のCommitで変更された4ファイルのみをデプロイ対象として判断したため、PR前半で変更されていた `css/toppage-contents.css` が反映対象から漏れた。

その結果、BLOGセクションの横スクロール用CSSがdev環境へ反映されず、4〜6件目の記事が縦方向に表示されるレイアウト崩れが発生した。

`css/toppage-contents.css` を追加反映したことで正常化し、その後Production環境への5ファイルの反映も正常に完了した。

### Takeaways

- デプロイ対象は最後のCommitだけで判断しない
- PRの Files changed 全体からデプロイ対象を確認する
- docsなど本番実行環境に不要なファイルと、テーマ・アプリケーションファイルを分離して判断する
- dev反映前に「Deployment Files」を明示する
- devで正常動作を確認してからProductionへ反映する
- Production反映後にもHuman Reviewを実施する

---

## L-0004

### Date

2026-08-21

### Related

I-0002
P-0001

### Lesson

開発ソースと実行ソースを分離しない。

### Context

AIが編集するファイルとHuman Reviewで確認するファイルが別コピーだと、同期漏れによって「修正済みだが画面に反映されていない」状態が発生する。

I-0001 では Cursor が GitHub リポジトリを編集し、XAMPP は別コピーのテーマを実行していた。

I-0002 にて XAMPP 側テーマを Git 管理テーマへの Junction とし、同一実体として一本化した。

### Takeaways

- Single Source of Truthを明確にする
- ローカル実行環境はGit管理ソースを直接参照する
- 手動コピーを開発フローに含めない
- AIと人間が同じソースを基準に確認する
- ローカル環境構築も再現可能な手順としてREADMEに残す

---

## Pending Issues

### P-0001

### Date

2026-08-21

### Related

I-0001
I-0002
D-0006

### Issue

GitHubリポジトリ（`andbld-website`）とXAMPP実体（`C:\xampp\htdocs\andbld-web`）が別コピーであり、同期漏れにより実画面へ変更が反映されない事象が発生した。

### Status

Resolved

### Note

I-0002 にて、XAMPP 側 `wp-content/themes/andbld` を Git 管理テーマへの Junction とし、Git working tree を Single Source of Truth とした。運用ルールは D-0006 および README の Local Development を参照する。
