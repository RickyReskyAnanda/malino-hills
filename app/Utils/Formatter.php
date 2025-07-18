<?php

namespace App\Utils;

class Formatter
{
    public static function zeropad($totalDigits, $value) {
        return str_pad($value, $totalDigits, '0', STR_PAD_LEFT);
    }
}
