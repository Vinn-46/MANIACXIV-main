<?php

namespace App\Enums;

enum WithdrawMultiplierEnum {
    case FIRST;
    case SECOND;
    case THIRD;

    public function value(): float {
        return match($this) {
            self::FIRST => 0.02,
            self::SECOND => 0.03,
            self::THIRD => 0.05,
        };
    }
}
