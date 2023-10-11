<?php

namespace App\Helpers;

class CalculateHelper
{
    public static function format(float $number): float
    {
        return round($number,2);
    }
}
