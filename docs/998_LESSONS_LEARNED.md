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

## Pending Issues

### P-0001

### Date

2026-08-21

### Related

I-0001

### Issue

GitHubリポジトリ（`andbld-website`）とXAMPP実体（`C:\xampp\htdocs\andbld-web`）が別コピーであり、同期漏れにより実画面へ変更が反映されない事象が発生した。

### Status

Open（開発環境の運用方法は未確定のため、正式Decisionにはしない）

### Note

今後、ローカル開発時の同期・配置ルールを確定し、必要に応じてDecision Logへ昇格する。
