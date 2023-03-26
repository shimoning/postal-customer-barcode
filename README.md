# Japan Postal Customer Barcode
郵便番号を含む住所を郵便局向けのカスタマバーコードに変換する


## Install
利用するプロジェクトの `composer.json` に以下を追加します。
```composer.json
"repositories": {
    "postal-customer-barcode": {
        "type": "vcs",
        "url": "https://github.com/shimoning/postal-customer-barcode.git"
    }
},
```

その後以下でインストールが可能です。

```bash
composer require shimoning/postal-customer-barcode
```


## Usage
TODO: write


## CLI
コマンドラインから以下で実行可能です。
```bash
php client
```

### 終了方法
終了する際は `exit` もしくは `Control + C` を入力してください。

### .env
`.env` ファイルを用意することで、`$options` と `$input` がデフォルトでセットされます。
ファイルの中身は `.env.example` を参考にしてください。
またコマンドライン中で `$_ENV['USER_ID']` と呼び出すことが可能です。

## ライセンスについて
当ライブラリは *MITライセンス* です。
[ライセンス](LICENSE) を読んでいただき、範囲内でご自由にご利用ください。
