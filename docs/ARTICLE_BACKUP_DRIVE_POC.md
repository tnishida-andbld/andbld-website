# Development投稿318のDriveバックアップPoC準備

2026-10-29。接続確認はrun `40844467699`で成功。
本段階では保存処理のコアをダミーデータでローカル検証した。実記事取得・Driveへの保存・WordPress復元は未実行。

## 対象と保存形式

- 対象はDevelopmentの投稿318、type=blog、slug=claude-code-github-ai-development-workflow、状態publish。
- 本文post_contentだけのバックアップ。タイトル・SEOメタ・画像・DB全体を復元できる完全バックアップではない。
- 本文の元バイト列をBase64にして、形式版数、環境、投稿ID、取得時刻、実行ID、サイズ、SHA256と一緒にJSONとして保存する。
- Base64は改行・HTMLを保持するための形式であり暗号化ではない。保管先の共有権限を維持し、外部AIへ送らない。
- 保存先は設定済みの専用共有ドライブ。Google Docsへの変換を行わず、JSONファイルを新規作成する。
- ファイル名に実行IDとランダムIDを付ける。既存ファイルの更新・削除はしない。
- 元本文は1byte〜2MiBに制限する。過去の観測サイズは期待値として固定しない。

## 保存・検証コア

`scripts/article_backup_store.py`は認証・ネットワーク接続・SSH・WordPress操作を持たないライブラリ。
ネットワーク処理を呼出元から渡す。現在その呼出元と実行workflowは未実装。

1. 本文と管理情報をJSONにする。
2. files.create（multipart、supportsAllDrives=true）で新規ファイルを作成する。
3. 作成結果のdriveId・parents・file IDを検査する。
4. 作成されたファイルだけをGETして、JSON全体のバイト一致と復号した本文の一致を確認する。
5. `backup_bytes_verified`を返す。WordPressへの復元成功とは扱わない。

アップロードの成否不明や読み戻し不一致では停止する。ファイルが残る可能性を明示し、自動再試行・削除をしない。
応答本文や例外詳細をログに出さない。将来の呼出元はfile IDも公開ログへ出さず、許可した結果項目だけを出力する。
保持期間は従来案の30日を目安とするが、復元検証まで保持し、このPoCには自動削除を実装しない。

## 未解決の取得経路

既存probeは本文のサイズ・ハッシュしか返さず、本文のエクスポートは実装されていない。
既存SSH鍵は通常のリモートコマンド実行が可能で、投稿318だけへ権限を限定した証拠がない。
`ARTICLE_EDITING.md`の専用経路を優先する方針を維持し、広い既存鍵をそのまま保存PoCへ流用しない。

保存先をサーバーからDriveへ変更しても、記事取得側の権限制限は解決しない。
専用鍵でサーバー側の固定エクスポート処理だけを呼び出す方式を第一候補とする。
エクスポート処理はDevelopmentの実体・DB・home/siteurl・投稿ID/type/slug/statusを再照合し、READ ONLYトランザクションで本文を1回取得する。
本文はSSHの標準出力からrunnerのメモリへ渡し、ログやartifactには出さない。取得時刻とサイズ・ハッシュは同じ本文から計算する。
これは従来の「本文をサーバー外へ返さない」案からの変更であり、実行前に対象と転送先を明示して承認する。

OpenSSHのcommand/restrictで通常シェル・任意入力・転送等を制限する案は、Xserverでの適用可否と維持条件が未確認。
サーバー側処理の配置先・所有権・更新経路・専用鍵設定・切戻し方法を具体化してからセットアップを承認する。
同じOSユーザーからの変更までは防げず、OS/DB自体の権限分離とは区別する。既存デプロイ設定を変更しない。

## 接続を完成させる前の要件

- 専用経路の可否調査。秘密鍵やauthorized_keys全体の提出を求めず、ファイルマネージャーのIP制限も解除しない。
- 認証付きHTTP処理に固定Google APIホスト、リダイレクト拒否、タイムアウト、応答サイズ上限、エラー抑制を実装する。
- 現在のdrive.readonlyでは保存できない。新規ファイルを扱うdrive.fileを第一候補に、共有ドライブルートへの作成可否をダミーデータで検証する。失敗時にdrive全体スコープへ自動拡大しない。
- mainから手動、development Environment、記事処理・デプロイとの排他。ユーザー指定の任意パス/投稿ID/コマンドを入力にしない。
- まず無機密のダミーファイル保存・読み戻しを1回、次に専用取得経路で実記事1件。各実行範囲の承認を受ける。
- 隔離投稿への復元試験は別段階。投稿318の変更・本番操作・定期実行は含めない。

## 検証済み

ネットワークを使わない6テストが成功。日本語・strong・CRLF・空行・pre内改行の保持、改変応答、異なる保存先、成否不明のアップロード、入力上限、新規名を検証。

`python -m unittest discover -s tests -p test_article_backup_store.py -v`

## 公式資料

- https://developers.google.com/workspace/drive/api/reference/rest/v3/files/create
- https://developers.google.com/workspace/drive/api/reference/rest/v3/files/get
- https://www.xserver.ne.jp/manual/man_server_ssh.php
- https://man.openbsd.org/sshd.8
