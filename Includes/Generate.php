<?php
/**
 * Includes/Generate.php.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 * @license MIT
 *
 * @link    https://github.com/Saibamen/Generate-Sort-Numbers
 */
/**
 * Functions for 'Generate' script.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 */

namespace Includes;

require_once 'Text.php';

/**
 * Functions for 'Generate' script.
 */
class Generate
{
    /**
     * Generate string with randomized numbers.
     *
     * @param int|float $min           Minimum allowed number to generate
     * @param int|float $max           Maximum allowed number to generate
     * @param int|float $decimalPlaces Number of decimal places
     *
     * @return string Generated string without trailing spaces
     */
    public static function generateRandomNumbers($min, $max, $decimalPlaces)
    {
        Text::message('GENERATING...');
        Text::debug("Generating string.\nMin: ".$min.' Max: '.$max.' Decimal places: '.$decimalPlaces);

        $range = $max - $min;
        $outputString = '';
        $howManyIterations = 100;

        $generateStart = microtime(true);

        // TODO: Show percent progress based on iteration
        // TODO: Calculate output size for generate
        for ($i = 0; $i <= $howManyIterations; $i++) {
            // Print progress and move cursor back to position 0
            echo 'Progress: '.$i.'/'.$howManyIterations."\r";

            $number = $min + $range * (mt_rand() / mt_getrandmax());
            // Format with trailing zeros ie. 8.00
            $number = number_format((float) $number, (int) $decimalPlaces, '.', '');
            $outputString .= $number.' ';
        }

        Text::printTimeDuration($generateStart);
        Text::debug($outputString);

        // Remove last space
        return trim($outputString);
    }

    /**
     * Switch min and max if min > max.
     *
     * @param float $min Minimum
     * @param float $max Maximum
     *
     * @return array
     */
    public static function checkSwitchMinMax($min, $max)
    {
        if ($min > $max) {
            Text::debug('!! Switching min and max !!');

            $tempMin = $min;

            $min = $max;
            $max = $tempMin;

            Text::debug('Min: '.$min);
            Text::debug('Max: '.$max);
        }

        return array('min' => $min, 'max' => $max);
    }
}
