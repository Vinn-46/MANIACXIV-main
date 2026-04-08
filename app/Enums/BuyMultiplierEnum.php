<?php

namespace App\Enums;

enum BuyMultiplierEnum {
    case FIRST;
    case SECOND;
    case THIRD;

    public function value(): float {
        return match($this) {
            self::FIRST => 0.03,
            self::SECOND => 0.05,
            self::THIRD => 0.08,
        };
    }
}
