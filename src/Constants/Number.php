<?php

namespace Shimoning\PostalCustomerBarcode\Constants;

enum Number: string
{
    case NUMBER_1   = '1';
    case NUMBER_2   = '2';
    case NUMBER_3   = '3';
    case NUMBER_4   = '4';
    case NUMBER_5   = '5';
    case NUMBER_6   = '6';
    case NUMBER_7   = '7';
    case NUMBER_8   = '8';
    case NUMBER_9   = '9';
    case NUMBER_0   = '0';
    case HYPHEN     = '-';

    /**
     * @return Bar[]
     */
    public function barMap(): array
    {
        return match ($this) {
            self::NUMBER_1  => [ Bar::LONG, Bar::LONG, Bar::TIMING ],
            self::NUMBER_2  => [ Bar::LONG, Bar::SEMI_LONG_BOTTOM, Bar::SEMI_LONG_TOP ],
            self::NUMBER_3  => [ Bar::SEMI_LONG_BOTTOM, Bar::LONG, Bar::SEMI_LONG_TOP ],
            self::NUMBER_4  => [ Bar::LONG, Bar::SEMI_LONG_TOP, Bar::SEMI_LONG_BOTTOM ],
            self::NUMBER_5  => [ Bar::LONG, Bar::TIMING, Bar::LONG ],
            self::NUMBER_6  => [ Bar::SEMI_LONG_BOTTOM, Bar::SEMI_LONG_TOP, Bar::LONG ],
            self::NUMBER_7  => [ Bar::SEMI_LONG_TOP, Bar::LONG, Bar::SEMI_LONG_BOTTOM ],
            self::NUMBER_8  => [ Bar::SEMI_LONG_TOP, Bar::SEMI_LONG_BOTTOM, Bar::LONG ],
            self::NUMBER_9  => [ Bar::TIMING, Bar::LONG, Bar::LONG ],
            self::NUMBER_0  => [ Bar::LONG, Bar::TIMING, Bar::TIMING ],
            self::HYPHEN    => [ Bar::TIMING, Bar::LONG, Bar::TIMING ],
        };
    }

    /**
     * 変換
     * @param string[] $characters
     * @return array
     */
    static public function convert(array $characters): array
    {
        $converted = [];
        foreach ($characters as $character) {
            if (\is_string($character) && $number = self::tryFrom($character)) {
                $converted[] = $number;
            } else {
                $converted[] = $character;
            }
        }
        return $converted;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return match ($this) {
            self::NUMBER_0  => 0,
            self::NUMBER_1  => 1,
            self::NUMBER_2  => 2,
            self::NUMBER_3  => 3,
            self::NUMBER_4  => 4,
            self::NUMBER_5  => 5,
            self::NUMBER_6  => 6,
            self::NUMBER_7  => 7,
            self::NUMBER_8  => 8,
            self::NUMBER_9  => 9,
            self::HYPHEN    => 10,
        };
    }

    static public function fromInt(int $number): self
    {
        return match ($number) {
            0  => self::NUMBER_0,
            1  => self::NUMBER_1,
            2  => self::NUMBER_2,
            3  => self::NUMBER_3,
            4  => self::NUMBER_4,
            5  => self::NUMBER_5,
            6  => self::NUMBER_6,
            7  => self::NUMBER_7,
            8  => self::NUMBER_8,
            9  => self::NUMBER_9,
            10 => self::HYPHEN,
        };
    }
}
