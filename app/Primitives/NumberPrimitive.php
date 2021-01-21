<?php


namespace App\Primitives;


class NumberPrimitive
{
    public static function toProtocol(int $number) : string
    {
        return '#' . str_pad($number, '6', '0', STR_PAD_LEFT);
    }
}
