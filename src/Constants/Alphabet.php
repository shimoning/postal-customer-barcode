<?php

namespace Shimoning\PostalCustomerBarcode\Constants;

enum Alphabet: string
{
    case A  = 'A';
    case B  = 'B';
    case C  = 'C';
    case D  = 'D';
    case E  = 'E';
    case F  = 'F';
    case G  = 'G';
    case H  = 'H';
    case I  = 'I';
    case J  = 'J';
    case K  = 'K';
    case L  = 'L';
    case M  = 'M';
    case N  = 'N';
    case O  = 'O';
    case P  = 'P';
    case Q  = 'Q';
    case R  = 'R';
    case S  = 'S';
    case T  = 'T';
    case U  = 'U';
    case V  = 'V';
    case W  = 'W';
    case X  = 'X';
    case Y  = 'Y';
    case Z  = 'Z';

    /**
     * @return [Control, Number]
     */
    public function map(): array
    {
        return match ($this) {
            self::A  => [ Control::CC1, Number::NUMBER_0 ],
            self::B  => [ Control::CC1, Number::NUMBER_1 ],
            self::C  => [ Control::CC1, Number::NUMBER_2 ],
            self::D  => [ Control::CC1, Number::NUMBER_3 ],
            self::E  => [ Control::CC1, Number::NUMBER_4 ],
            self::F  => [ Control::CC1, Number::NUMBER_5 ],
            self::G  => [ Control::CC1, Number::NUMBER_6 ],
            self::H  => [ Control::CC1, Number::NUMBER_7 ],
            self::I  => [ Control::CC1, Number::NUMBER_8 ],
            self::J  => [ Control::CC1, Number::NUMBER_9 ],

            self::K  => [ Control::CC2, Number::NUMBER_0 ],
            self::L  => [ Control::CC2, Number::NUMBER_1 ],
            self::M  => [ Control::CC2, Number::NUMBER_2 ],
            self::N  => [ Control::CC2, Number::NUMBER_3 ],
            self::O  => [ Control::CC2, Number::NUMBER_4 ],
            self::P  => [ Control::CC2, Number::NUMBER_5 ],
            self::Q  => [ Control::CC2, Number::NUMBER_6 ],
            self::R  => [ Control::CC2, Number::NUMBER_7 ],
            self::S  => [ Control::CC2, Number::NUMBER_8 ],
            self::T  => [ Control::CC2, Number::NUMBER_9 ],

            self::U  => [ Control::CC3, Number::NUMBER_0 ],
            self::V  => [ Control::CC3, Number::NUMBER_1 ],
            self::W  => [ Control::CC3, Number::NUMBER_2 ],
            self::X  => [ Control::CC3, Number::NUMBER_3 ],
            self::Y  => [ Control::CC3, Number::NUMBER_4 ],
            self::Z  => [ Control::CC3, Number::NUMBER_5 ],
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
            if (\is_string($character) && $alphabet = self::tryFrom($character)) {
                \array_push($converted, ...$alphabet->map());
            } else {
                $converted[] = $character;
            }
        }
        return $converted;
    }
}
