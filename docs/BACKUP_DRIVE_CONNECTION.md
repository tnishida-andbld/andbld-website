# Development記事バックアップ：Google Drive接続確認

I-0007の追加準備。PC停止中も動く保存先として専用共有ドライブを利用する方針。
この段階は接続確認だけであり、記事取得・バックアップ保存・復元・定期実行は未実装。
Productionへの接続・更新は対象外。

## 実装範囲

- `Check backup Drive (read only)`を承認後にmainから手動実行する。
- Environmentは`development`。既存のブランチ制限を維持する。
- 専用バックアップサービスアカウントをWorkload Identity Federationで利用する。JSON鍵は作成しない。
- 300秒のアクセストークンに`drive.readonly`スコープを指定する。
- `drives.get`で設定済み共有ドライブのIDのみ取得し、要求したIDとの一致を確認する。
- 記事本文・ファイル一覧・ファイル本文・メンバー一覧は取得しない。SSH接続、Drive書き込みも行わない。
- ドライブID・API応答・トークンをスクリプトのログに出さない。認証アクションの設定識別子はログに現れる可能性がある。
- APIリダイレクトには追従しない。失敗時に自動リトライ・権限拡張はしない。

## 実行前の設定

GitHubの`development` Environment variablesへ以下を登録する。実値を公開リポジトリへ記載しない。

- `BACKUP_DRIVE_ID`: Humanが作成した専用共有ドライブのID
- `BACKUP_WIF_PROVIDER`: バックアップ用プールのプロバイダ完全リソース名
- `BACKUP_SERVICE_ACCOUNT`: バックアップ専用サービスアカウントのメールアドレス

Google側の前提:

- Google Drive APIが有効。
- バックアップ専用サービスアカウントに対象共有ドライブの投稿者権限。
- 対象リポジトリの数値IDに対し、専用サービスアカウントのWorkload Identity User権限。
- プロバイダ条件で所有者ID・リポジトリID・main・workflow_dispatch・developmentを制限。
- 分析用サービスアカウントとプールは変更しない。

プール条件はワークフローファイル単位の制限ではない。同じ条件を満たす別ワークフローにも認証可能なため、mainの変更レビューとEnvironment設定を維持する。
今回の読み取りスコープはこの実行の制限であり、サービスアカウント自身の投稿者権限を読み取り専用に変更するものではない。

## 結果の判断

`shared_drive_connection_verified`は共有ドライブのメタデータ取得成功のみを示す。
ファイル保存可否、保存データの完全性、復元可能性、サーバー接続権限の分離は未検証。
HTTP 401/403/404等で失敗した場合、設定・API有効化・共有ドライブ権限を確認する。未承認で権限を追加しない。

将来の保存PoCでは別途、対象記事・取得方法・保存内容・読戻しハッシュ照合・復元手順・保持期間を確定する。
投稿者権限では既存ファイルの編集も可能なので、改変不能なバックアップとは扱わない。
削除の自動化はこの段階に含めない。

## 検証

ネットワークを使わないテスト:
`python -m unittest discover -s tests -p test_backup_drive.py -v`

実接続テストはPRマージと手動実行のHuman承認後に1回実施し、Run IDと結果を記録する。

## 公式資料

- [Google auth Action](https://github.com/google-github-actions/auth)
- [共有ドライブのメタデータ取得](https://developers.google.com/workspace/drive/api/reference/rest/v3/drives/get)
