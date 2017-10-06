<?php
/**
 * Functions for 'Generate' script
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
    debug("Generating string.\nMin: ".$min.' Max: '.$max.' DecimalPlaces: '.$decimalPlaces);

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
        debug($number);
        $outputString .= $number.' ';
    }

    printEndTime($GENERATE_START);

    // Remove last space
    return trim($outputString);
}

/**
 * Get number from User.
 *
 * @param string $message Message for User what he must type
 *
 * @return string Inserted number
 */
function getNumberInput($message)
{
    echo $message.': ';

    do {
        $input = trim(fgets(STDIN));
        debug('User input: '.$input);

        $isInputWrong = is_null($input) || !is_numeric($input);

        // TODO: Use default numbers?
        if ($isInputWrong) {
            echo 'Please input number: ';
        }
    } while ($isInputWrong);

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
