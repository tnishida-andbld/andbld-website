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
