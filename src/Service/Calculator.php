<?php

declare(strict_types=1);

namespace App\Service;

class Calculator
{
    private const SCALE = 14;

    public function divideNums($num1, $num2): float
    {
        return (float)bcdiv((string)$num1, (string)$num2, self::SCALE);
    }

    public function multiplyNums($num1, $num2): float
    {
        return (float)bcmul((string)$num1, (string)$num2, self::SCALE);
    }
}
