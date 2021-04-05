<?php

namespace frontend\helpers;


/**
 * @note
 * helpers
 * needed for auxiliary situations in different classes
 */

/**
 * @note
 * for last time visit
 *
 * Class PluralFormHelper
 * @package frontend\helpers
 */
class PluralFormHelper
{
    /**
     * @param int $n
     * @param string $option1
     * @param string $option2
     * @param string $option3
     * @return string
     */
    public static function format(
        int $n,
        string $option1,
        string $option2,
        string $option3
    ): string
    {
        $n = $n % 10;
        if ($n === 1) {
            return $option1;
        } elseif ($n >= 2 && $n <= 4) {
            return $option2;
        }

        return $option3;
    }
}
