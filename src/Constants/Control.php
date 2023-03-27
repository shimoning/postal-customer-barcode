<?php

namespace Shimoning\PostalCustomerBarcode\Constants;

enum Control: string
{
    case CC1    = 'CC1';
    case CC2    = 'CC2';
    case CC3    = 'CC3';
    case CC4    = 'CC4';
    case CC5    = 'CC5';
    case CC6    = 'CC6';
    case CC7    = 'CC7';
    case CC8    = 'CC8';
    case START  = 'STC';
    case END    = 'SPC';

    /**
     * @return Bar[]
     */
    public function barMap(): array
    {
        return match ($this) {
            self::CC1   => [ Bar::SEMI_LONG_BOTTOM, Bar::SEMI_LONG_TOP, Bar::TIMING ],
            self::CC2   => [ Bar::SEMI_LONG_BOTTOM, Bar::TIMING, Bar::SEMI_LONG_TOP ],
            self::CC3   => [ Bar::SEMI_LONG_TOP, Bar::SEMI_LONG_BOTTOM, Bar::TIMING ],
            self::CC4   => [ Bar::TIMING, Bar::SEMI_LONG_BOTTOM, Bar::SEMI_LONG_TOP ],
            self::CC5   => [ Bar::SEMI_LONG_TOP, Bar::TIMING, Bar::SEMI_LONG_BOTTOM ],
            self::CC6   => [ Bar::TIMING, Bar::SEMI_LONG_TOP, Bar::SEMI_LONG_BOTTOM ],
            self::CC7   => [ Bar::TIMING, Bar::TIMING, Bar::LONG ],
            self::CC8   => [ Bar::LONG, Bar::LONG, Bar::LONG ],
            self::START => [ Bar::NONE, Bar::LONG, Bar::SEMI_LONG_BOTTOM ],
            self::END   => [ Bar::SEMI_LONG_BOTTOM, Bar::LONG, Bar::NONE ],
        };
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return match ($this) {
            self::CC1   => 11,
            self::CC2   => 12,
            self::CC3   => 13,
            self::CC4   => 14,
            self::CC5   => 15,
            self::CC6   => 16,
            self::CC7   => 17,
            self::CC8   => 18,
        };
    }

    static public function fromInt(int $number): self
    {
        return match ($number) {
            11 => self::CC1,
            12 => self::CC2,
            13 => self::CC3,
            14 => self::CC4,
            15 => self::CC5,
            16 => self::CC6,
            17 => self::CC7,
            18 => self::CC8,
        };
    }
}
