# Japan Postal Customer Barcode
郵便番号と住所を郵便局向けのカスタマバーコードに変換する


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
使い方

### Generator
郵便番号と住所からバーコード画像を生成する。
現在は png のみ対応。

* GD プラグインが必須。
* ImageMagick については未サポート(開発予定)。

#### png
```php
Generator::png(
    '100-0013',
    '東京都千代田区霞が関1丁目3番2号　郵便プラザ503室',
);
```

**Arguments**
| Name       | Type          | Required | Default | Description                 |
|:-----------|:--------------|:---------|:--------|:----------------------------|
| `zip_code` | string        | true     | `true`  | 郵便番号 (半角、全角、スペース、ハイフン有無) |
| `address`  | string        | true     | `true`  | 都道府県からの住所 |
| `options`  | array or null | false    | `null`  | オプション (後述) |

**Options**
| Name             | Type       | Required | Default           | Description      |
|:-----------------|:-----------|:---------|:------------------|:-----------------|
| `width_factor`   | int        | false    | `true`            | バー1本あたりの横幅 |
| `foreground_rgb` | array      | false    | `[0, 0, 0]`       | バーの色          |
| `background_rgb` | array      | false    | `[255, 255, 255]` | バーの背景色       |
| `filepath`       | string     | false    | `null`            | 出力ファイルパス    |

---

### Extractor
郵便番号と住所からバーコードに必要な情報を抜き出す。
基本的に単体で使うことはほぼない。

[公式情報](https://www.post.japanpost.jp/zipcode/zipmanual/p17.html)

#### extract
郵便番号と住所からバーコードに必要な情報を抜き出す。

```php
$extracted = Extractor::extract(
    '100-0013',
    '東京都千代田区霞が関1丁目3番2号　郵便プラザ503室',
); // 10000131-3-2-503
```

#### extractAddressB
住所からバーコードに必要な情報を抜き出す。

```php
$extracted = Extractor::extractAddressB(
    '東京都千代田区霞が関1丁目3番2号　郵便プラザ503室',
); // 1-3-2-503
```

#### extractNumber
文字列から半角数字を取り出す。
全角数字は半角数字に変換される。

```php
Extractor::extractNumber('100-0013'); // 1000013
Extractor::extractNumber('1234567'); // 1234567
Extractor::extractNumber('１２３ー４５６７'); // 1234567
```

#### isZipCode
郵便番号かチェックする。

```php
Extractor::isZipCode('100-0013'); // true
Extractor::isZipCode('1234567'); // true
Extractor::isZipCode('１２３ー４５６７'); // false
```

#### replaceKanji2Number
漢数字を半角数字に置換する。

```php
Extractor::replaceKanji2Number('十'); // 10
Extractor::replaceKanji2Number('十一'); // 11
Extractor::replaceKanji2Number('二十一'); // 21
```

### Converter
extractor で抽出された文字列を各種変換加工する。
基本的に単体で使うことはほぼない。

#### convert
extractor で抽出された文字列をバーコード定数の配列に変換する。

```php
$bars = Converter::convert($extracted);
```

#### data2Codes
extractor で抽出された文字列をコード定数の配列に変換する。
```php
$codes = Converter::data2Codes($extracted);
```

#### data2Array
extractor で抽出された文字列を文字列の配列に変換する。
```php
$arrayedString = Converter::data2Array($extracted);
```

#### format
文字列の配列をコード定数の配列に変換し、長さも規定に揃える。
```php
$formatted = Converter::format($arrayedString);
```

#### checkDigit
コード定数の配列からチェックデジットを計算し取得する。
```php
$checkDigit = Converter::checkDigit($formatted);
```

#### addControls
文字列の配列をコード定数に チェックデジット と 開始/終了のコードを付与する。
```php
$codesForBarcode = Converter::addControls($formatted, $checkDigit);
```

---

## CLI
コマンドラインから以下で実行可能です。
```bash
php client
```

### 終了方法
`exit` もしくは `Control + C` を入力してください。

## ライセンスについて
当ライブラリは *MITライセンス* です。
[ライセンス](LICENSE) を読んでいただき、範囲内でご自由にご利用ください。
