<?php

namespace Shimoning\PostalCustomerBarcode\Constants;

enum Bar: int
{
    case NONE               = 0;
    case LONG               = 1;
    case SEMI_LONG_TOP      = 2;
    case SEMI_LONG_BOTTOM   = 3;
    case TIMING             = 4;

    public function height(): int
    {
        return match ($this) {
            self::NONE              => 0,
            self::LONG              => 6,
            self::SEMI_LONG_TOP     => 4,
            self::SEMI_LONG_BOTTOM  => 4,
            self::TIMING            => 2,
        };
    }

    public function position(): int
    {
        return match ($this) {
            self::NONE              => 0,
            self::LONG              => 0,
            self::SEMI_LONG_TOP     => 0,
            self::SEMI_LONG_BOTTOM  => 2,
            self::TIMING            => 2,
        };
    }
}
