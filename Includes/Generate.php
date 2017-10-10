<?php
/**
 * Includes/Generate.php.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 * @license MIT
 *
 * @link    https://github.com/Saibamen/Generate-Sort-Numbers
 */

namespace Includes;

require_once 'Text.php';

/**
 * Functions for 'Generate' script.
 */
class Generate
{
    /**
     * @var bool If true - print less information for eg. Travis or CircleCI to avoid big log file.
     */
    private static $testingMode = false;

    /**
     * Generate string with randomized numbers.
     *
     * @param int|float    $min           Minimum allowed number to generate
     * @param int|float    $max           Maximum allowed number to generate
     * @param int|float    $decimalPlaces Number of decimal places
     * @param int          $maxFileSize   Maximum file size in bytes
     * @param string       $filename      Output filename without extension
     * @param string|mixed $delimiter     Delimiter. Default is ' '
     * @param string       $fileExtension File extension. Default is '.dat'
     *
     * @see Generate::getMinMaxNumberSize()
     * @see File::createMissingDirectory()
     * @see File::checkIfFileExists()
     */
    public static function generateAndSaveRandomNumbers($min, $max, $decimalPlaces, $maxFileSize, $filename, $delimiter = ' ', $fileExtension = '.dat')
    {
        $range = $max - $min;

        $minMaxNumberSize = self::getMinMaxNumberSize($min, $max, $decimalPlaces);

        if ($minMaxNumberSize['max'] > $maxFileSize) {
            die('Error: Cannot generate any number due to too low file size.');
        }

        File::createMissingDirectory($filename);
        File::checkIfFileExistsAndDeleteContent($filename, $fileExtension);

        // Maximum iteration without delimiter
        $maximumIteration = (int) ($maxFileSize / $minMaxNumberSize['max']);
        Text::debug('First maximum iteration: '.$maximumIteration);

        $findingStart = microtime(true);

        Text::message('Finding maximum iteration for loop...');

        for ($i = 0; ; $i++) {
            $tempMaxIteration = $maximumIteration - $i;
            $maximumBytes = ($minMaxNumberSize['max'] * $tempMaxIteration) + $tempMaxIteration - strlen($delimiter);

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

        $file = fopen($filename.$fileExtension, 'w');

        for ($i = 1; $i <= $maximumIteration; $i++) {
            // Print progress and move cursor back to position 0
            if (!self::getTesting()) {
                echo 'Progress: '.$i.'/'.$maximumIteration."\r";
            }

            // Random number
            $number = $min + $range * (mt_rand() / mt_getrandmax());
            // Format with trailing zeros ie. 8.00
            $number = number_format((float) $number, (int) $decimalPlaces, '.', '');

            $outputString = $number.$delimiter;

            // Remove last delimiter
            if ($i === $maximumIteration) {
                $outputString = rtrim($outputString, $delimiter);
            }

            fwrite($file, $outputString);
        }

        fclose($file);

        Text::printTimeDuration($generateStart);
        Text::message('Output file '.$filename.$fileExtension.' generated with '.filesize($filename.$fileExtension).' bytes.');
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
    private static function getMinMaxNumberSize($min, $max, $decimalPlaces)
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

    /**
     * Set $testingMode property value.
     *
     * @param bool $value
     *
     * @see Generate::$testingMode
     */
    public static function setTesting($value)
    {
        self::$testingMode = $value;
    }

    /**
     * Get $testingMode property value.
     *
     * @return bool
     *
     * @see Generate::$testingMode
     */
    public static function getTesting()
    {
        return self::$testingMode;
    }
}
