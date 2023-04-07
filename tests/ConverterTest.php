<?php

use PHPUnit\Framework\TestCase;
use Shimoning\PostalCustomerBarcode\Extractor;
use Shimoning\PostalCustomerBarcode\Converter;
use Shimoning\PostalCustomerBarcode\Exceptions\InvalidCodableStringException;

class ConverterTest extends TestCase
{
    /**
     * 公式に載っているテスト
     *
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p25.html
     * @return void
     */
    public function test_officialCases()
    {
        foreach ($this->cases as $case) {
            $extracted = Extractor::extract($case['zip_code'], $case['address']);
            $codes = Converter::data2Codes($extracted);

            $stringifiedCodes = [];
            foreach ($codes as $code) {
                $stringifiedCodes[] = $code->value;
            }

            $this->assertEquals(\implode(' ', $stringifiedCodes), $case['codes']);
        }
    }

    public function test_convertFalsy()
    {
        $this->expectException(InvalidCodableStringException::class);
        $this->expectExceptionMessage('半角英数とハイフンのみ入力可能です。');
        Converter::data2Codes('あいうえお');
    }

    public function test_convertNull()
    {
        $this->expectException(InvalidCodableStringException::class);
        $this->expectExceptionMessage('半角英数とハイフンのみ入力可能です。');
        Converter::data2Codes('');
    }

    /**
     * テストケース
     *
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p25.html
     * @var array
     */
    private $cases = [
        [
            'zip_code' => '2 6 3 0 0 2 3',
            'address' => '千葉市稲毛区緑町3丁目30-8　郵便ビル403号',
            'codes' => 'STC 2 6 3 0 0 2 3 3 - 3 0 - 8 - 4 0 3 CC4 CC4 CC4 5 SPC',
        ],
        [
            'zip_code' => '0 1 4 0 1 1 3',
            'address' => '秋田県大仙市堀見内　南田茂木　添60-1',
            'codes' => 'STC 0 1 4 0 1 1 3 6 0 - 1 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC8 SPC',
        ],
        [
            'zip_code' => '1 1 0 0 0 1 6',
            'address' => '東京都台東区台東5-6-3　ABCビル10F',
            'codes' => 'STC 1 1 0 0 0 1 6 5 - 6 - 3 - 1 0 CC4 CC4 CC4 CC4 CC4 9 SPC',
        ],
        [
            'zip_code' => '0 6 0 0 9 0 6',
            'address' => '北海道札幌市東区北六条東4丁目　郵便センター6号館',
            'codes' => 'STC 0 6 0 0 9 0 6 4 - 6 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 9 SPC',
        ],
        [
            'zip_code' => '0 6 5 0 0 0 6',
            'address' => '北海道札幌市東区北六条東8丁目　郵便センター10号館',
            'codes' => 'STC 0 6 5 0 0 0 6 8 - 1 0 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 9 SPC',
        ],
        [
            'zip_code' => '4 0 7 0 0 3 3',
            'address' => '山梨県韮崎市龍岡町下條南割　韮崎400',
            'codes' => 'STC 4 0 7 0 0 3 3 4 0 0 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 - SPC',
        ],
        [
            'zip_code' => '2 7 3 0 1 0 2',
            'address' => '千葉県鎌ケ谷市右京塚　東3丁目-20-5　郵便・A&bコーポB604号',
            'codes' => 'STC 2 7 3 0 1 0 2 3 - 2 0 - 5 CC1 1 6 0 4 CC4 CC4 0 SPC',
        ],
        [
            'zip_code' => '1 9 8 0 0 3 6',
            'address' => '東京都青梅市河辺町十一丁目六番地一号　郵便タワー601',
            'codes' => 'STC 1 9 8 0 0 3 6 1 1 - 6 - 1 - 6 0 1 CC4 CC4 CC4 CC8 SPC',
        ],
        [
            'zip_code' => '0 2 7 0 2 0 3',
            'address' => '岩手県宮古市大字津軽石第二十一地割大淵川480',
            'codes' => 'STC 0 2 7 0 2 0 3 2 1 - 4 8 0 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC5 SPC',
        ],
        [
            'zip_code' => '5 9 0 0 0 1 6',
            'address' => '大阪府堺市堺区中田出井町四丁六番十九号',
            'codes' => 'STC 5 9 0 0 0 1 6 4 - 6 - 1 9 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC2 SPC',
        ],
        [
            'zip_code' => '0 8 0 0 8 3 1',
            'address' => '北海道帯広市稲田町南七線　西28',
            'codes' => 'STC 0 8 0 0 8 3 1 7 - 2 8 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC7 SPC',
        ],
        [
            'zip_code' => '3 1 7 0 0 5 5',
            'address' => '茨城県日立市宮田町6丁目7-14　ABCビル2F',
            'codes' => 'STC 3 1 7 0 0 5 5 6 - 7 - 1 4 - 2 CC4 CC4 CC4 CC4 CC4 CC1 SPC',
        ],
        [
            'zip_code' => '6 5 0 0 0 4 6',
            'address' => '神戸市中央区港島中町9丁目7-6　郵便シティA棟1F1号',
            'codes' => 'STC 6 5 0 0 0 4 6 9 - 7 - 6 CC1 0 1 - 1 CC4 CC4 CC4 5 SPC',
        ],
        [
            'zip_code' => '6 2 3 0 0 1 1',
            'address' => '京都府綾部市青野町綾部6-7　LプラザB106',
            'codes' => 'STC 6 2 3 0 0 1 1 6 - 7 CC2 1 CC1 1 1 0 6 CC4 CC4 CC4 4 SPC',
        ],
        [
            'zip_code' => '0 6 4 0 8 0 4',
            'address' => '札幌市中央区南四条西29丁目1524-23　第2郵便ハウス501',
            'codes' => 'STC 0 6 4 0 8 0 4 2 9 - 1 5 2 4 - 2 3 - 2 - 3 SPC',
        ],
        [
            'zip_code' => '9 1 0 0 0 6 7',
            'address' => '福井県福井市新田塚3丁目80-25　J1ビル2-B',
            'codes' => 'STC 9 1 0 0 0 6 7 3 - 8 0 - 2 5 CC1 9 1 - 2 CC1 9 SPC',
        ],
    ];
}
