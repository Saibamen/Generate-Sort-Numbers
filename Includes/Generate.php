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
     * @param int       $maxFileSize   Maximum file size in bytes
     *
     * @return string Generated string without trailing spaces
     */
    public static function generateRandomNumbers($min, $max, $decimalPlaces, $maxFileSize)
    {
        $range = $max - $min;
        $outputString = '';

        $minMaxNumberSize = self::getMinMaxNumberSize($min, $max, $decimalPlaces);

        if ($minMaxNumberSize['max'] > $maxFileSize) {
            die('Error: Cannot generate any number due to too low file size.');
        }

        // Maximum iteration without spaces
        $maximumIteration = (int) ($maxFileSize / $minMaxNumberSize['max']);
        Text::debug('First maximum iteration: '.$maximumIteration);

        $findingStart = microtime(true);

        Text::message('Finding maximum iteration for loop...');

        for ($i = 0; ; $i++) {
            $tempMaxIteration = $maximumIteration - $i;
            $maximumBytes = ($minMaxNumberSize['max'] * $tempMaxIteration) + $tempMaxIteration - 1;

            if ($maxFileSize >= $maximumBytes) {
                $maximumIteration = $tempMaxIteration;
                Text::debug('Found right max iteration for loop');
                break;
            }
        }

        Text::printTimeDuration($findingStart);

        Text::message('GENERATING...');
        Text::debug('Min: '.$min.' Max: '.$max.' Decimal places: '.$decimalPlaces.' Size: '.$maxFileSize."\nMaximum iteration: ".$maximumIteration."\n");

        $generateStart = microtime(true);

        for ($i = 1; $i <= $maximumIteration; $i++) {
            // Print progress and move cursor back to position 0
            echo 'Progress: '.$i.'/'.$maximumIteration."\r";

            // Random number
            $number = $min + $range * (mt_rand() / mt_getrandmax());
            // Format with trailing zeros ie. 8.00
            $number = number_format((float) $number, (int) $decimalPlaces, '.', '');
            $outputString .= $number.' ';
        }

        Text::printTimeDuration($generateStart);
        Text::debug('Output string has '.strlen(trim($outputString)).' bytes.');

        // Remove last space
        return trim($outputString);
    }

    /**
     * Switch min and max if min > max.
     *
     * @param int|float $min           Minimum allowed number to generate
     * @param int|float $max           Maximum allowed number to generate
     * @param int|float $decimalPlaces Number of decimal places
     *
     * @return array
     */
    public static function getMinMaxNumberSize($min, $max, $decimalPlaces)
    {
        $additionalBytes = null;

        if ((int) $decimalPlaces > 0) {
            // + 1 for decimal point
            $additionalBytes = (int) $decimalPlaces + 1;
        }

        $minimumNumberSize = min(strlen((int) $min), strlen((int) $max)) + $additionalBytes;
        $maximumNumberSize = max(strlen((int) $min), strlen((int) $max)) + $additionalBytes;

        Text::debug('Minimum number size: '.$minimumNumberSize);
        Text::debug('Maximum number size: '.$maximumNumberSize);

        return array('min' => $minimumNumberSize, 'max' => $maximumNumberSize);
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
