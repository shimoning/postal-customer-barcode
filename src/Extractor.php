<?php

namespace Shimoning\PostalCustomerBarcode;

/**
 * バーコードに必要な文字情報を抜き出す
 */
class Extractor
{
    /**
     * バーコードに必要な文字情報を抜き出す
     *
     * @param string|integer $zipCode
     * @param string $address
     * @return string|false
     */
    public static function extract(string|int $zipCode, string $address): string|bool
    {
        // 郵便番号から情報を抜き出す
        $zipCode = static::extractNumber($zipCode);
        if (! static::isZipCode($zipCode)) {
            // TODO: throw exception
            return false;
        }

        // 住所から情報を抜き出す
        $addressB = static::extractAddressB($address);  // 不要かも？
        return $zipCode . static::extractFromAddressB($addressB);
    }

    /**
     * 住所から 住所A(町域名までの住所) を削除し 住所B(町域名以降の住所) だけ取り出す。
     *
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p18.html
     * @param string $address
     * @return string
     */
    public static function extractAddressB(string $address): string
    {
        // TODO: 北海道以外のケース
        return \preg_replace('/\A北海道札幌市(.+?)区(東|西|南|北)(.+?)条/u', '', \trim($address));
    }

    /**
     * 住所Bから英数字およびハイフンを取り出す
     *
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p19.html
     * @param string $addressB
     * @return string
     */
    public static function extractFromAddressB(string $addressB): string
    {
        // 0. 英数字を半角に
        $addressB = \mb_convert_kana(\trim($addressB), 'a');

        // 1. 大文字に変換
        $addressB = \mb_strtoupper($addressB);

        // 2. 「&」(アンパサンド)、「/」(スラッシュ)、「・」(中グロ)、「.」(ピリオド)を削除
        $addressB = \preg_replace('/[&＆\/／\.・]/u', '', $addressB);

        // 3. 連続した英字を削除 (安全のため - に置き換える)
        $addressB = \preg_replace('/[A-Z]{2,}/', '-', $addressB);

        // 3.1 特定文字の前の漢数字を算用数字に置換する
        $addressB = \preg_replace_callback('/([一二三四五六七八九十]+)(丁目|丁|番地|番|号|地割|線|の|ノ)/u', function ($matches) {
            return static::replaceKanji2Number($matches[1]) . $matches[2];
        }, $addressB);

        // 4. 英数字以外を - に置き換える
        $addressB = \preg_replace('/[^0-9A-Z\-]/u', '-', $addressB);

        // 4-1. 数字+F で終わる時は F削除
        $addressB = preg_replace('/([0-9]+)F\z/u', '$1', $addressB);
        // 4-2. 数字+F に続きがある場合は F を - にする
        $addressB = preg_replace('/([0-9]+)F/u', '$1-', $addressB);

        // 5. 2つ以上並んだ - を削除
        $addressB = \preg_replace('/-{2,}/u', '-', $addressB);

        // 5-1. 英字の前後の - は削除
        $addressB = preg_replace('/[\-]([A-Z]+)/u', '$1', $addressB);
        $addressB = preg_replace('/([A-Z]+)[\-]/u', '$1', $addressB);

        // 6. 先頭と末尾の - を削除
        $addressB = \trim($addressB, '-');

        return $addressB;
    }

    /**
     * 住所に含まれる漢数字を数字にする
     * TODO: 百以上の漢数字
     *
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p25.html
     * @param string $string
     * @return string
     */
    public static function replaceKanji2Number(string $numericKanji): string
    {
        if (\preg_match('/\A十\z/', $numericKanji)) {
            return 10;
        }

        // n十 の時は n0 にする (一旦、十 を x に置き換える)
        $numericKanji = \preg_replace('/([一二三四五六七八九]+)十\z/u', '$1x', $numericKanji);
        $numericKanji = \str_replace('x', '0', $numericKanji); // x を 0 に戻す

        // n十m の時は nmにする
        $numericKanji = preg_replace('/([一二三四五六七八九]+)十/u', '$1', $numericKanji);

        // 十m の時は 1m にする
        $numericKanji = preg_replace('/十([一二三四五六七八九]+)/u', '1$1', $numericKanji);

        // 単体の漢数字
        return \str_replace(
            ['一','二', '三', '四', '五', '六', '七', '八', '九'],
            ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $numericKanji,
        );
    }

    /**
     * 文字列から半角数字を取り出す
     *
     * @param string $numeric
     * @return string
     */
    public static function extractNumber(string $numeric): string
    {
        return \preg_replace('/[^0-9]/u', '', \mb_convert_kana($numeric, 'n'));
    }

    /**
     * 郵便番号かどうかをチェックする
     *
     * @param string|integer $zipCode
     * @return boolean
     */
    public static function isZipCode(string|int $zipCode): bool
    {
        return \preg_match('/\A[0-9]{3}-?[0-9]{4}\z/', $zipCode) === 1;
    }
}
