<?php

namespace Shimoning\PostalCustomerBarcode;

use Shimoning\PostalCustomerBarcode\Constants\Bar;
use Shimoning\PostalCustomerBarcode\Constants\ImageLibrary;

/**
 * バーコードを出力する
 */
class Generator
{
    const BASE_WIDTH = 2;
    const DEFAULT_WIDTH_FACTOR = 2;
    const DEFAULT_FOREGROUND_RGB = [0, 0, 0];
    const DEFAULT_BACKGROUND_RGB = [255, 255, 255];

    /**
     * PNG画像を出力する
     *
     * @param string|integer $zipCode
     * @param string $address
     * @param array|null $options
     * @return string|false
     */
    public static function png(string|int $zipCode, string $address, $options = null): string|bool
    {
        $data = Extractor::extract($zipCode, $address);
        $bars = Converter::convert($data);
        if (!$bars) {
            return false;
        }

        $widthFactor = $options['width_factor'] ?? self::DEFAULT_WIDTH_FACTOR;
        $fgRgb = $options['foreground_rgb'] ?? self::DEFAULT_FOREGROUND_RGB;
        $bgRgb = $options['background_rgb'] ?? self::DEFAULT_BACKGROUND_RGB;
        $filepath = $options['filepath'] ?? null;

        $width = (\count($bars) * 2 - 1) * $widthFactor;
        $height = Bar::LONG->height() * $widthFactor;
        $library = self::resolveLibrary();

        if ($library === ImageLibrary::GD) {
            $image = \imagecreate($width, $height);
            $bgColor = \imagecolorallocate($image, $bgRgb[0], $bgRgb[1], $bgRgb[2]);
            \imagecolortransparent($image, $bgColor);
            $fgColor = \imagecolorallocate($image, $fgRgb[0], $fgRgb[1], $fgRgb[2]);
        } else {
            // TODO: imagick
        }

        $px = 0;
        foreach ($bars as $bar) {
            if ($bar !== Bar::NONE) {
                $barHeight = $bar->height() * $widthFactor;
                $py = $bar->position() * $widthFactor;
                if ($library === ImageLibrary::GD) {
                    \imagefilledrectangle(
                        $image,
                        $px, $py,
                        $px + $widthFactor - 1, $py + $barHeight - 1,
                        $fgColor,
                    );
                } else {
                    // TODO: imagick
                }
            }
            $px += self::BASE_WIDTH * $widthFactor;
        }

        // 出力
        if ($filepath && \file_exists(\dirname($filepath))) {
            if ($library === ImageLibrary::GD) {
                \imagepng($image, $filepath);
                \imagedestroy($image);
            } else {
                // TODO: imagick
            }

            return $filepath;
        } else {
            ob_start();
            if ($library === ImageLibrary::GD) {
                \imagepng($image);
                \imagedestroy($image);
            } else {
                // TODO: imagick
            }
            $png = \ob_get_clean();

            return $png;
        }
    }

    public static function resolveLibrary(): ImageLibrary|bool
    {
        if (\function_exists('imagecreate')) {
            return ImageLibrary::GD;
        } else if (\extension_loaded('imagick')) {
            return ImageLibrary::IMAGE_MAGICK;
        } else {
            // TODO: throw exception
            return false;
        }
    }
}
