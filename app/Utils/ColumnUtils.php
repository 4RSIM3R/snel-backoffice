<?php

namespace App\Utils;

class ColumnUtils
{

    public static function whatsapp($state): string
    {
        return sprintf("https://wa.me/%s", $state);
    }

}
