<?php

use PHPUnit\Framework\TestCase;
use Shimoning\PostalCustomerBarcode\Extractor;

class ExtractorTest extends TestCase
{
    /**
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p25.html
     * @return void
     */
    public function test_officialCases()
    {
        foreach ($this->cases as $case) {
            $result = Extractor::extract($case['zip_code'], $case['address']);
            $this->assertEquals(\preg_replace('[\s]', '', $case['extracted']), $result);
        }
    }

    public function test_extractNumber()
    {
        $cases = [
            [
                'input' => '2 6 3 0 0 2 3',
                'expect' => '2630023',
            ],
            [
                'input' => '0 1 4 0 1 1 3',
                'expect' => '0140113',
            ],
            [
                'input' => '1234567',
                'expect' => '1234567',
            ],
            [
                'input' => '123-4567',
                'expect' => '1234567',
            ],
            [
                'input' => '１２３４５６７',
                'expect' => '1234567',
            ],
            [
                'input' => '１２３ー４５６７',
                'expect' => '1234567',
            ],
            [
                'input' => '１２３ー４５６７あいうえお',
                'expect' => '1234567',
            ],
        ];
        foreach ($cases as $case) {
            $result = Extractor::extractNumber($case['input']);
            $this->assertEquals($case['expect'], $result);
        }
    }

    public function test_replaceKanji2Number()
    {
        $cases = [
            [
                'input' => '一',
                'expect' => '1',
            ],
            [
                'input' => '十',
                'expect' => '10',
            ],
            [
                'input' => '十一',
                'expect' => '11',
            ],
            [
                'input' => '二十',
                'expect' => '20',
            ],
            [
                'input' => '二十一',
                'expect' => '21',
            ],
            [
                'input' => '二一',
                'expect' => '21',
            ],
            [
                'input' => '一十',
                'expect' => '10',
            ],
        ];
        foreach ($cases as $case) {
            $result = Extractor::replaceKanji2Number($case['input']);
            $this->assertEquals($case['expect'], $result);
        }
    }

    private $cases = [
        [
            'zip_code' => '2 6 3 0 0 2 3',
            'address' => '千葉市稲毛区緑町3丁目30-8　郵便ビル403号',
            'extracted' => '2 6 3 0 0 2 3 3 - 3 0 - 8 - 4 0 3',
        ],
        [
            'zip_code' => '0 1 4 0 1 1 3',
            'address' => '秋田県大仙市堀見内　南田茂木　添60-1',
            'extracted' => '0 1 4 0 1 1 3 6 0 - 1',
        ],
        [
            'zip_code' => '1 1 0 0 0 1 6',
            'address' => '東京都台東区台東5-6-3　ABCビル10F',
            'extracted' => '1 1 0 0 0 1 6 5 - 6 - 3 - 1 0',
        ],
        [
            'zip_code' => '0 6 0 0 9 0 6',
            'address' => '北海道札幌市東区北六条東4丁目　郵便センター6号館',
            'extracted' => '0 6 0 0 9 0 6 4 - 6',
        ],
        [
            'zip_code' => '0 6 5 0 0 0 6',
            'address' => '北海道札幌市東区北六条東8丁目　郵便センター10号館',
            'extracted' => '0 6 5 0 0 0 6 8 - 1 0',
        ],
        [
            'zip_code' => '4 0 7 0 0 3 3',
            'address' => '山梨県韮崎市龍岡町下條南割　韮崎400',
            'extracted' => '4 0 7 0 0 3 3 4 0 0',
        ],
        [
            'zip_code' => '2 7 3 0 1 0 2',
            'address' => '千葉県鎌ケ谷市右京塚　東3丁目-20-5　郵便・A&bコーポB604号',
            'extracted' => '2 7 3 0 1 0 2 3 - 2 0 - 5 B 6 0 4',
        ],
        [
            'zip_code' => '1 9 8 0 0 3 6',
            'address' => '東京都青梅市河辺町十一丁目六番地一号　郵便タワー601',
            'extracted' => '1 9 8 0 0 3 6 1 1 - 6 - 1 - 6 0 1',
        ],
        [
            'zip_code' => '0 2 7 0 2 0 3',
            'address' => '岩手県宮古市大字津軽石第二十一地割大淵川480',
            'extracted' => '0 2 7 0 2 0 3 2 1 - 4 8 0',
        ],
        [
            'zip_code' => '5 9 0 0 0 1 6',
            'address' => '大阪府堺市堺区中田出井町四丁六番十九号',
            'extracted' => '5 9 0 0 0 1 6 4 - 6 - 1 9',
        ],
        [
            'zip_code' => '0 8 0 0 8 3 1',
            'address' => '北海道帯広市稲田町南七線　西28',
            'extracted' => '0 8 0 0 8 3 1 7 - 2 8',
        ],
        [
            'zip_code' => '3 1 7 0 0 5 5',
            'address' => '茨城県日立市宮田町6丁目7-14　ABCビル2F',
            'extracted' => '3 1 7 0 0 5 5 6 - 7 - 1 4 - 2',
        ],
        [
            'zip_code' => '6 5 0 0 0 4 6',
            'address' => '神戸市中央区港島中町9丁目7-6　郵便シティA棟1F1号',
            'extracted' => '6 5 0 0 0 4 6 9 - 7 - 6 A 1 - 1',
        ],
        [
            'zip_code' => '6 2 3 0 0 1 1',
            'address' => '京都府綾部市青野町綾部6-7　LプラザB106',
            'extracted' => '6 2 3 0 0 1 1 6 - 7 L B 1 0 6',
        ],
        [
            'zip_code' => '0 6 4 0 8 0 4',
            'address' => '札幌市中央区南四条西29丁目1524-23　第2郵便ハウス501',
            'extracted' => '0 6 4 0 8 0 4 2 9 - 1 5 2 4 - 2 3 - 2 - 501',
        ],
        [
            'zip_code' => '9 1 0 0 0 6 7',
            'address' => '福井県福井市新田塚3丁目80-25　J1ビル2-B',
            'extracted' => '9 1 0 0 0 6 7 3 - 8 0 - 2 5 J 1 - 2B',
        ],
    ];
}
