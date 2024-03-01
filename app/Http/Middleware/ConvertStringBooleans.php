<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertStringBooleans extends TransformsRequest
{
    protected function transform($key, $value)
    {
        /**
         * Intentionally done by request from the FE
         */
        if ($key === 'category_id' || $key === 'avail_qty') {
            
            $cleanedValue = $this->removeDuplicateQuotes($value);

            return $cleanedValue;
        }

        if($value === 'true' || $value === 'TRUE')
            return true;

        if($value === 'false' || $value === 'FALSE')
            return false;

        return $value;
    }

    private function removeDuplicateQuotes(string $string)
    {
        return trim($string, '"\'');
    }
}