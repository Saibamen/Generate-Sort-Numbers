<?php

require_once 'text.inc.php';

/**
 * @param $min
 * @param $max
 * @param $decimalPlaces
 *
 * @return string
 */
function generateOutputString($min, $max, $decimalPlaces)
{
    // TODO: Inform User how long it take
    debug("Generating string.\nMin: ".$min.' Max: '.$max.' DecimalPlaces: '.$decimalPlaces);
    define('GENERATE_START', microtime(true));

    $range = $max - $min;
    $outputString = '';

    // TODO: Calculate output size for generate
    for ($i = 0; $i < 10; $i++) {
        $number = $min + $range * (mt_rand() / mt_getrandmax());
        // Format with trailing zeros ie. 8.00
        $number = number_format((float) $number, $decimalPlaces, '.', '');
        debug($number);
        $outputString .= $number.' ';
    }

    // Remove last space
    return trim($outputString);
}

/**
 * @param $message
 *
 * @return string
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
 * @return string
 */
function getOutputFilename()
{
    echo 'Type output filename (without extension): ';

    do {
        $input = trim(fgets(STDIN));
        debug('User input: '.$input);

        /*
         * TODO: Invalid characters:
         * (Windows)    \/:*?"<>|   (check \ and / only at the end of string - need to test)
         * (Linux)      /
         */
        $isInputWrong = is_null($input);

        if ($isInputWrong) {
            echo 'Please input filename: ';
        }
    } while ($isInputWrong);

    return $input;
}

/**
 * @param $string
 * @param $filename
 * @param string $fileExtension
 */
function saveStringToFile($string, $filename, $fileExtension = '.dat')
{
    // Create dir if not exists
    if (!is_dir(dirname($filename))) {
        debug('Creating missing directory: '.dirname($filename));
        mkdir(dirname($filename));
    }

    // Warn about overwriting file
    if (file_exists($filename.$fileExtension)) {
        text('File '.$filename.$fileExtension.' exists and it will be overwritten!');
    }

    debug('Saving generated string to file.');

    $outputFileBytes = file_put_contents($filename.$fileExtension, $string, LOCK_EX);

    text('Output file '.$filename.$fileExtension.' generated with '.$outputFileBytes.' bytes.');

    $endTime = microtime(true) - GENERATE_START;
    $endTime = number_format((float) $endTime, 4, '.', '');
    text('It was done in '.$endTime.' ms.');
}

// Switch Globals min and max if min > max
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
