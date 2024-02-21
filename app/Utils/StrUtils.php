<?php

namespace App\Utils;

class StrUtils
{

    public static function companyAlias(string $name): string
    {
        $words = explode(' ', $name);
        $shortened = '';

        foreach ($words as $word) {
            // Take the first letter of each word and concatenate
            $shortened .= strtoupper(substr($word, 0, 1));
        }

        return $shortened;
    }

    public static function rupiahFormat($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }


}
