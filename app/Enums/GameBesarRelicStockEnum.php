<?php

namespace App\Enums;

enum GameBesarRelicStockEnum {
    // FIRST 
    case FIRST_RED;
    case FIRST_PURPLE;
    case FIRST_BLUE;

    // SECOND
    case SECOND_RED;
    case SECOND_PURPLE;
    case SECOND_BLUE;

    // THIRD
    case THIRD_RED;
    case THIRD_PURPLE;
    case THIRD_BLUE;

    public function value(): int {
        return match($this) {
            self::FIRST_RED, self::FIRST_PURPLE, self::SECOND_BLUE => 10,
            self::FIRST_BLUE, self::SECOND_RED, self::SECOND_PURPLE, self::THIRD_RED, self::THIRD_BLUE => 20,
            self::THIRD_PURPLE => 30
        };
    }
}
