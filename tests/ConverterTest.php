<?php

use PHPUnit\Framework\TestCase;
use Shimoning\PostalCustomerBarcode\Extractor;
use Shimoning\PostalCustomerBarcode\Converter;

class ConverterTest extends TestCase
{
    /**
     * @link https://www.post.japanpost.jp/zipcode/zipmanual/p25.html
     * @return void
     */
    public function test_official1()
    {
        $result = $this->getCodes(
            '2 6 3 0 0 2 3',
            '千葉市稲毛区緑町3丁目30-8　郵便ビル403号',
        );
        $this->assertEquals('STC 2 6 3 0 0 2 3 3 - 3 0 - 8 - 4 0 3 CC4 CC4 CC4 5 SPC', $result);
    }

    public function test_official2()
    {
        $result = $this->getCodes(
            '0 1 4 0 1 1 3',
            '秋田県大仙市堀見内　南田茂木　添60-1',
        );
        $this->assertEquals('STC 0 1 4 0 1 1 3 6 0 - 1 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC8 SPC', $result);
    }

    public function test_official3()
    {
        $result = $this->getCodes(
            '1 1 0 0 0 1 6',
            '東京都台東区台東5-6-3　ABCビル10F',
        );
        $this->assertEquals('STC 1 1 0 0 0 1 6 5 - 6 - 3 - 1 0 CC4 CC4 CC4 CC4 CC4 9 SPC', $result);
    }

    public function test_official4()
    {
        $result = $this->getCodes(
            '0 6 0 0 9 0 6',
            '北海道札幌市東区北六条東4丁目　郵便センター6号館',
        );
        $this->assertEquals('STC 0 6 0 0 9 0 6 4 - 6 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 9 SPC', $result);
    }

    public function test_official5()
    {
        $result = $this->getCodes(
            '0 6 5 0 0 0 6',
            '北海道札幌市東区北六条東8丁目　郵便センター10号館',
        );
        $this->assertEquals('STC 0 6 5 0 0 0 6 8 - 1 0 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 9 SPC', $result);
    }

    public function test_official6()
    {
        $result = $this->getCodes(
            '4 0 7 0 0 3 3',
            '山梨県韮崎市龍岡町下條南割　韮崎400',
        );
        $this->assertEquals('STC 4 0 7 0 0 3 3 4 0 0 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 - SPC', $result);
    }

    public function test_official7()
    {
        $result = $this->getCodes(
            '2 7 3 0 1 0 2',
            '千葉県鎌ケ谷市右京塚　東3丁目-20-5　郵便・A&bコーポB604号',
        );
        $this->assertEquals('STC 2 7 3 0 1 0 2 3 - 2 0 - 5 CC1 1 6 0 4 CC4 CC4 0 SPC', $result);
    }

    public function test_official8()
    {
        $result = $this->getCodes(
            '1 9 8 0 0 3 6',
            '東京都青梅市河辺町十一丁目六番地一号　郵便タワー601',
        );
        $this->assertEquals('STC 1 9 8 0 0 3 6 1 1 - 6 - 1 - 6 0 1 CC4 CC4 CC4 CC8 SPC', $result);
    }

    public function test_official9()
    {
        $result = $this->getCodes(
            '0 2 7 0 2 0 3',
            '岩手県宮古市大字津軽石第二十一地割大淵川480',
        );
        $this->assertEquals('STC 0 2 7 0 2 0 3 2 1 - 4 8 0 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC5 SPC', $result);
    }

    public function test_official10()
    {
        $result = $this->getCodes(
            '5 9 0 0 0 1 6',
            '大阪府堺市堺区中田出井町四丁六番十九号',
        );
        $this->assertEquals('STC 5 9 0 0 0 1 6 4 - 6 - 1 9 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC2 SPC', $result);
    }

    public function test_official11()
    {
        $result = $this->getCodes(
            '0 8 0 0 8 3 1',
            '北海道帯広市稲田町南七線　西28',
        );
        $this->assertEquals('STC 0 8 0 0 8 3 1 7 - 2 8 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC4 CC7 SPC', $result);
    }

    public function test_official12()
    {
        $result = $this->getCodes(
            '3 1 7 0 0 5 5',
            '茨城県日立市宮田町6丁目7-14　ABCビル2F',
        );
        $this->assertEquals('STC 3 1 7 0 0 5 5 6 - 7 - 1 4 - 2 CC4 CC4 CC4 CC4 CC4 CC1 SPC', $result);
    }

    public function test_official13()
    {
        $result = $this->getCodes(
            '6 5 0 0 0 4 6',
            '神戸市中央区港島中町9丁目7-6　郵便シティA棟1F1号',
        );
        $this->assertEquals('STC 6 5 0 0 0 4 6 9 - 7 - 6 CC1 0 1 - 1 CC4 CC4 CC4 5 SPC', $result);
    }

    public function test_official14()
    {
        $result = $this->getCodes(
            '6 2 3 0 0 1 1',
            '京都府綾部市青野町綾部6-7　LプラザB106',
        );
        $this->assertEquals('STC 6 2 3 0 0 1 1 6 - 7 CC2 1 CC1 1 1 0 6 CC4 CC4 CC4 4 SPC', $result);
    }

    public function test_official15()
    {
        $result = $this->getCodes(
            '0 6 4 0 8 0 4',
            '札幌市中央区南四条西29丁目1524-23　第2郵便ハウス501',
        );
        $this->assertEquals('STC 0 6 4 0 8 0 4 2 9 - 1 5 2 4 - 2 3 - 2 - 3 SPC', $result);
    }

    public function test_official16()
    {
        $result = $this->getCodes(
            '9 1 0 0 0 6 7',
            '福井県福井市新田塚3丁目80-25　J1ビル2-B',
        );
        $this->assertEquals('STC 9 1 0 0 0 6 7 3 - 8 0 - 2 5 CC1 9 1 - 2 CC1 9 SPC', $result);
    }

    private function getCodes(string|int $zipCode, string $address): string
    {
        $extracted = Extractor::extract($zipCode, $address);
        $codes = Converter::data2Codes($extracted);

        $stringifiedCodes = [];
        foreach ($codes as $code) {
            $stringifiedCodes[] = $code->value;
        }

        return implode(' ', $stringifiedCodes);
    }
}
