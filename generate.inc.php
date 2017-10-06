<?php
/**
 * Functions for 'Generate' script.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 */

/** Functions for inputs, saving file and printing text */
require_once 'console.inc.php';

/**
 * Generate string with randomized numbers.
 *
 * @param string $min           Minimum allowed number to generate
 * @param string $max           Maximum allowed number to generate
 * @param string $decimalPlaces Number of decimal places
 *
 * @return string Generated string without trailing spaces
 */
function generateRandomNumbers($min, $max, $decimalPlaces)
{
    text('GENERATING...');
    debug("Generating string.\nMin: ".$min.' Max: '.$max.' Decimal places: '.$decimalPlaces);

    $range = $max - $min;
    $outputString = '';
    $howManyIterations = 10;

    $GENERATE_START = microtime(true);

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

    printEndTime($GENERATE_START);
    debug($outputString);

    // Remove last space
    return trim($outputString);
}

/**
 * Get number from User.
 *
 * @param string $message Message for User what he must type
 * @param int    $default Default number for empty input. Default is 0
 *
 * @return string Inserted number
 */
function getNumberInput($message, $default = 0)
{
    echo $message.' [Default: '.$default.']: ';

    do {
        $input = trim(fgets(STDIN));
        debug('User input: '.$input);

        if (is_null($input) || empty($input)) {
            debug('Using default input: '.$default);
            $input = $default;
        } elseif (!is_numeric($input)) {
            echo 'Please input number: ';
        }
    } while (!is_numeric($input));

    return $input;
}

/**
 * Switch Globals min and max if min > max.
 */
function checkSwitchGlobalMinMax()
{
    if ($GLOBALS['min'] > $GLOBALS['max']) {
        debug('!! Switching min and max !!');

        $tempMin = $GLOBALS['min'];

        $GLOBALS['min'] = $GLOBALS['max'];
        $GLOBALS['max'] = $tempMin;

        debug('Min: '.$GLOBALS['min']);
        debug('Max: '.$GLOBALS['max']);
    }
}
