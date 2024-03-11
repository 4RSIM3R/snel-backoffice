<?php

namespace App\Utils;

class StyleUtils
{

    public static function getStatusColor($status): string
    {
        if (str_contains($status, 'cancel') || str_contains($status, 'dismiss'))  return 'danger';
        if (str_contains($status, 'need') || str_contains($status, 'wait') || str_contains($status, 'in')) return 'warning';
        if (str_contains($status, 'done') || str_contains($status, 'approve')) return 'success';
        return 'white';
    }

}
