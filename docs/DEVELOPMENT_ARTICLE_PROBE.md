# Development記事の読み取り調査

I-0007 / D-0018。記事操作自動化の可否を調べる手動Actions。記事更新・デプロイは行わない。

## 実行と結果

承認・mainへのマージ後、`Inspect Development article (read only)`をmainで手動実行する。入力項目・定期実行・PR起動はない。既存development EnvironmentのSSH Secretsを利用し、既存デプロイと同じconcurrency groupで直列化する。

対象はDevelopmentの投稿318、type=blog、slug=claude-code-github-ai-development-workflow、status=publishに固定。接続先DBはD-0016のDevelopment DBとの一致を要求する。本文、ユーザー情報、DB認証情報、サーバー絶対パスをログ・artifactに保存しない。

サマリーに出すのは投稿ID、PHP版、WP-CLIがPATH上に存在するか、本文バイト数・SHA256、バックアップ候補となる親ディレクトリの書き込み可否だけ。SSH権限範囲、WP-CLI実動作、バックアップ作成・復元は未検証と明記する。既存DBユーザーの権限を読み取り専用へ変更するものではない。

## 保護と限界

- SSHのホスト鍵を検証。キーは一時runner内に作り、終了時に削除。秘密値はコマンド文字列や出力へ展開しない。
- パスをローカル側で検査し、サーバー側realpathでDevelopmentのディレクトリ要素・テーマ末尾を照合。外部へのwp-configシンボリックリンクは拒否する。
- wp-configを実行せずPHPトークンとして解析する。DB定数とtable_prefixの単純リテラルだけ対応。動的定義・重複・未対応形式は停止する。
- WordPress、テーマ、プラグイン、WP-CLIを起動しない。プラグイン起動時の副作用を避ける。DBはREAD ONLYトランザクション内でhome/siteurlと投稿識別情報・本文長・ハッシュだけSELECTし、rollbackして終了する。
- ファイル作成、記事更新、ユーザー/キー発行、権限変更、Production照会、DB全体取得、ソフト導入はない。通常のSSH/DBアクセスログはサーバー側に残り得る。
- 成功は将来の更新権限やバックアップ可否の保証ではない。既存SSH鍵が本番へ到達できないことを証明する調査ではなく、本番へアクセスして試さない。書き込みPoC前に鍵・OS権限の分離または制限付き実行経路を設計する。
- PHP/mysqli/READ ONLY非対応、構成不一致、JSON以外のログ混入、タイムアウトは失敗する。元のエラーには秘密情報が含まれ得るため出力しない。失敗時に権限を広げたり設定を書き換えたりして再試行しない。

## 次の判断

成功後も、本文バックアップの非公開保存先・保持期間・復元試験、WP-CLI実動作、更新直前の本文ハッシュ一致確認、記事318限定の操作権限を別途決める。公開サイトを含む権限を持つSSHキーをDevin等のExecutorへ直接渡さない。
本調査は非公開の分析リポジトリにサイト更新権限を追加しない。I-0007全体の完了を意味しない。

## 検証

`python3 -m unittest discover -s tests -p test_development_probe.py`

`php -l scripts/probe-development.php`

`php tests/test_probe_config.php`

テストはローカルのfixtureとモックのみ。実サーバー接続を含まない。画面変更はなくスクリーンショットは対象外。

## 初回実行記録（2026-10-28）

- PR #17をHuman承認後にマージ。main SHA: `811b1c2743b68d9f7c9b902575b3bcef99bc83e4`
- [run 40672671213](https://github.com/tnishida-andbld/andbld-website/actions/runs/40672671213): workflow_dispatch、main、attempt 1、Failure
- checkout成功後、調査スクリプトがexit 1。初版は全例外を同じメッセージへ集約していたため、停止段階・原因は特定できない。接続・記事照合の成功を主張しない。
- 記事更新コマンドは含まない。サーバー設定の変更・権限拡張・再実行は行っていない。
- 診断修正案は、runner設定/一時認証ファイル/SSH/PHP不在/応答解析/設定解析/DB/サイト照合/記事照合/応答検証/summary書き込みの固定コードだけを表示する。リモートの自由文・例外メッセージ・stderrは引き続き非表示。
- Node.js/runner移行の警告もあったが、checkoutは成功している。今回の原因とは断定しない。

## 2回目の実行と診断改善

- PR #18をHuman承認後にマージ。main SHA: `d247eea99974612130c527a3385f1d14f6458663`
- [run 40673399735](https://github.com/tnishida-andbld/andbld-website/actions/runs/40673399735): workflow_dispatch、main、Failure、stage=`remote_response`
- この分類だけでは空応答・JSON以外の応答・リモート異常終了を区別できない。DBや記事照合の成功、SSH認証失敗、PHP設定不良のいずれも断定しない。
- 改善版は終了コード、stdoutの形式（empty/non_json/object/other_json）、stderrの有無と固定エラーマーカー分類だけを表示する。生のstdout/stderrや例外本文は引き続き出さない。
- exit 255はSSHとリモートプログラムのどちらでも返り得るため、認証失敗と決めつけない。エラーマーカーも原因確定ではなく切り分け材料とする。
- SQL・認証・接続先・権限・リモート調査コマンドは変更しない。新たなサーバー設定変更や調査対象の拡大はない。

## 3回目の実行と到達目印

- PR #19を承認後マージ。main: `c511b3ea94863b451064f60bbeb95b6fbdd27de8`
- [run 40674674585](https://github.com/tnishida-andbld/andbld-website/actions/runs/40674674585): Failure、14秒、`remote_output_empty`。終了コード0、stdout/stderrとも空。取得成功とは扱わない。
- シェル開始、phpコマンド存在確認、PHPコード開始、PHPコマンド終了の固定目印をstderrへ出す。完全一致する許可リストのみサマリーへ転記し、他の出力は非表示にする。`stderr_present`は既知目印を除いた出力の有無を表す。
- PHPがCLI以外で実行された場合は固定目印`non_cli`を出して終了21で停止する。別のPHPを自動選択したり設定を変更したりしない。
- 目印がないことだけで認証・権限・PHPの障害を断定しない。PHP終了の目印も記事取得成功を意味しない。既存のJSON・対象照合が成功条件。
- 調査対象、SQL、SSH権限は維持。WordPressや本番への変更なし。
- 検証: `PHP_TEST_BINARY`にローカルPHP実行ファイルを指定すると、生成されたPHPコマンドを存在しないfixtureパスで実行し、安全なinstallationエラーとPHP開始目印を確認する。未指定時はこの1件をskipする。今回10件すべてPASS。実サーバーの実行結果ではない。

## 4回目の結果とPHP互換性の確認

- PR #20を承認後マージ。main: `620e77d681ef46c4d7c3553fe9d52366edb75623`
- [run 40675678725](https://github.com/tnishida-andbld/andbld-website/actions/runs/40675678725): Failure、14秒。shell_started / php_found / php_started / php_finishedを確認。終了コード0、JSONは空。記事取得は未確認。
- 次の診断ではPHP_VERSION_IDを5〜6桁の整数としてのみ記録。複数出力や不正な形式はnullとし、任意文字列は記録しない。
- 調査コードの読込とprobe_main呼出しを分離。PHP 8未満は調査開始前にphp_versionで停止。CLI以外はphp_sapiで停止。eval例外はphp_eval、読込失敗または関数不在はphp_loadとして停止する。
- サーバー側PHPの実際の版数や根本原因は未確定。別PHPの自動選択・アップグレード・設定変更はしない。
- ローカルPHPを使う12テストPASS。構文不正・false返却・関数未定義を再現し、秘密文字列を表示せず固定エラーになることを確認。旧PHP実機での検証は未実施。
- SQL、記事識別、読み取り専用トランザクション、接続先・権限は維持。新しい実行は承認後に1回のみ。
