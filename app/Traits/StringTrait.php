<?php

namespace App\Traits;

trait StringTrait
{

    public function companyAlias(string $name): string
    {
        $words = explode(' ', $name);
        $shortened = '';

        foreach ($words as $word) {
            // Take the first letter of each word and concatenate
            $shortened .= strtoupper(substr($word, 0, 1));
        }

        return $shortened;
    }

}
