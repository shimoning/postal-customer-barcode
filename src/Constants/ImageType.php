<?php

namespace Shimoning\PostalCustomerBarcode\Constants;

enum ImageType: string
{
    case PNG = 'png';

    public function extension(): string
    {
        return match ($this) {
            self::PNG   => 'png',
        };
    }
}
