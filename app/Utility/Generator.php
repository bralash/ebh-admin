<?php

namespace App\Utility;

/**
 * The generator utility class
 */
class Generator
{
    /**
     * Generate a random code
     *
     * @param  int  $length
     * @return string
     */
    public static function generateCode($length, $flag = null)
    {
        $alphaUpper = range('A', 'Z');
        $alphaLower = range('a', 'z');
        $numeric = range(0, 9);

        switch ($flag) {
            case 'ALPHA':
                $letters = \array_merge($alphaUpper, $alphaLower);
                break;

            case 'ALPHA_NUM':
                $letters = \array_merge($alphaUpper, $alphaLower, $numeric);
                break;

            case 'ALPHA_UPPER_NUM':
                $letters = \array_merge($alphaUpper, $numeric);
                break;

            case 'ALPHA_LOWER_NUM':
                $letters = \array_merge($alphaLower, $numeric);
                break;

            default:
                $letters = $numeric;
                break;
        }

        $pass = "";

        for ($i = 0; $i < $length; $i++) {
            $char = $letters[rand(1, count($letters) - 1)];
            $pass .= $char;
        }

        return $pass;
    }
}
