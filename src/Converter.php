<?php

namespace Shimoning\PostalCustomerBarcode;

use Shimoning\PostalCustomerBarcode\Constants\Bar;
use Shimoning\PostalCustomerBarcode\Constants\Number;
use Shimoning\PostalCustomerBarcode\Constants\Control;
use Shimoning\PostalCustomerBarcode\Constants\Alphabet;

/**
 * 英数字をバーコード用のコードに変換する
 *
 * @link https://www.post.japanpost.jp/zipcode/zipmanual/p11.html
 */
class Converter
{
    const CODE_LENGTH = 20;

    /**
     * バーに変換
     *
     * @param string $data
     * @return Bar[]|false
     */
    static public function convert(string $data): array|bool
    {
        if (!\preg_match('/\A[0-9A-Z-]+\z/', $data)) {
            // TODO: throw exception
            return false;
        }

        // 1文字ずつ分解
        $characters = \str_split($data);

        // 形式を整える
        $formatted = self::format($characters);

        // チェックデジット
        $checkDigit = self::checkDigit($formatted);

        // 先頭に STC を加える
        \array_unshift($formatted, Control::START);

        // 末尾にチェックデジットと SPC を加える
        $formatted[] = $checkDigit;
        $formatted[] = Control::END;

        // バーに変換する
        $bars = [];
        foreach ($formatted as $code) {
            array_push($bars, ...$code->barMap());
        }
        return $bars;
    }

    /**
     * 形式を整える
     *
     * @param string[] $characters
     * @return (Number|Control)[] $characters
     */
    static public function format(array $characters): array
    {
        // 数字を置換
        $characters = Number::convert($characters);

        // アルファベットを置換
        $characters = Alphabet::convert($characters);

        // 20文字まで埋める
        $length = count($characters);
        if ($length < self::CODE_LENGTH) {
            for ($i = $length; $i < self::CODE_LENGTH; $i++) {
                $characters[] = Control::CC4;
            }
        }

        // 20文字より多ければ削る
        $characters = \array_slice($characters, 0, self::CODE_LENGTH);

        return $characters;
    }

    /**
     * チェックデジットの計算
     *
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p21.html
     * @param (Number|Control)[] $characters
     * @return Number|Control
     */
    static public function checkDigit(array $characters)
    {
        $sum = 0;
        foreach ($characters as $character) {
            $sum += $character->toInt();
        }
        $div = \intval(\floor($sum / 19));
        $checkDigit = ($div + 1) * 19 - $sum;

        return $checkDigit > 10
            ? Control::fromInt($checkDigit)
            : Number::fromInt($checkDigit);
    }
}
