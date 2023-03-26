<?php

use PHPUnit\Framework\TestCase;
use Shimoning\PostalCustomerBarcode\Extractor;

class ExtractorTest extends TestCase
{
    /**
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p25.html
     * @return void
     */
    public function test_official()
    {
        $result = Extractor::extract(
            '2 6 3 0 0 2 3',
            '千葉市稲毛区緑町3丁目30-8　郵便ビル403号',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '2 6 3 0 0 2 3 3 - 3 0 - 8 - 4 0 3'), $result);

        $result = Extractor::extract(
            '0 1 4 0 1 1 3',
            '秋田県大仙市堀見内　南田茂木　添60-1',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '0 1 4 0 1 1 3 6 0 - 1'), $result);

        $result = Extractor::extract(
            '1 1 0 0 0 1 6',
            '東京都台東区台東5-6-3　ABCビル10F',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '1 1 0 0 0 1 6 5 - 6 - 3 - 1 0'), $result);

        $result = Extractor::extract(
            '0 6 0 0 9 0 6',
            '北海道札幌市東区北六条東4丁目　郵便センター6号館',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '0 6 0 0 9 0 6 4 - 6'), $result);

        $result = Extractor::extract(
            '0 6 5 0 0 0 6',
            '北海道札幌市東区北六条東8丁目　郵便センター10号館',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '0 6 5 0 0 0 6 8 - 1 0'), $result);

        $result = Extractor::extract(
            '4 0 7 0 0 3 3',
            '山梨県韮崎市龍岡町下條南割　韮崎400',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '4 0 7 0 0 3 3 4 0 0'), $result);

        $result = Extractor::extract(
            '2 7 3 0 1 0 2',
            '千葉県鎌ケ谷市右京塚　東3丁目-20-5　郵便・A&bコーポB604号',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '2 7 3 0 1 0 2 3 - 2 0 - 5 B 6 0 4'), $result);

        $result = Extractor::extract(
            '1 9 8 0 0 3 6',
            '東京都青梅市河辺町十一丁目六番地一号　郵便タワー601',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '1 9 8 0 0 3 6 1 1 - 6 - 1 - 6 0 1'), $result);

        $result = Extractor::extract(
            '0 2 7 0 2 0 3',
            '岩手県宮古市大字津軽石第二十一地割大淵川480',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '0 2 7 0 2 0 3 2 1 - 4 8 0'), $result);

        $result = Extractor::extract(
            '5 9 0 0 0 1 6',
            '大阪府堺市堺区中田出井町四丁六番十九号',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '5 9 0 0 0 1 6 4 - 6 - 1 9'), $result);

        $result = Extractor::extract(
            '0 8 0 0 8 3 1',
            '北海道帯広市稲田町南七線　西28',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '0 8 0 0 8 3 1 7 - 2 8'), $result);

        $result = Extractor::extract(
            '3 1 7 0 0 5 5',
            '茨城県日立市宮田町6丁目7-14　ABCビル2F',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '3 1 7 0 0 5 5 6 - 7 - 1 4 - 2'), $result);

        $result = Extractor::extract(
            '6 5 0 0 0 4 6',
            '神戸市中央区港島中町9丁目7-6　郵便シティA棟1F1号',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '6 5 0 0 0 4 6 9 - 7 - 6 A 1 - 1'), $result);

        $result = Extractor::extract(
            '6 2 3 0 0 1 1',
            '京都府綾部市青野町綾部6-7　LプラザB106',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '6 2 3 0 0 1 1 6 - 7 L B 1 0 6'), $result);

        $result = Extractor::extract(
            '0 6 4 0 8 0 4',
            '札幌市中央区南四条西29丁目1524-23　第2郵便ハウス501',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '0 6 4 0 8 0 4 2 9 - 1 5 2 4 - 2 3 - 2 - 501'), $result);

        $result = Extractor::extract(
            '9 1 0 0 0 6 7',
            '福井県福井市新田塚3丁目80-25　J1ビル2-B',
        );
        $this->assertEquals(\preg_replace('[\s]', '', '9 1 0 0 0 6 7 3 - 8 0 - 2 5 J 1 - 2B'), $result);
    }
}
