<?php
namespace generate_sort_numbers\console;
/**
 * Functions for console scripts.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 */

use generate_sort_numbers\text;

require_once 'text.php';

/**
 * Saves string to file.
 *
 * @param string $string        String to save
 * @param string $filename      Output filename without extension
 * @param string $fileExtension File extension. Default is '.dat'
 *
 * @see generateRandomNumbers()
 */
function saveStringToFile($string, $filename, $fileExtension = '.dat')
{
    // Create dir if not exists
    if (!is_dir(dirname($filename))) {
        text\debug('Creating missing directory: '.dirname($filename));
        mkdir(dirname($filename));
    }

    // Warn about overwriting file
    if (file_exists($filename.$fileExtension)) {
        text\text('File '.$filename.$fileExtension.' exists and it will be overwritten!');
        getUserConfirm(true);
    }

    text\text('Saving to file...');

    $outputFileBytes = file_put_contents($filename.$fileExtension, $string, LOCK_EX);

    text\text('Output file '.$filename.$fileExtension.' generated with '.$outputFileBytes.' bytes.');
}

/**
 * Get filename from User.
 *
 * @param string $message Message for User what he must type
 *
 * @return string Inserted filename
 */
function getFilenameInput($message)
{
    echo $message.': ';

    do {
        $input = trim(fgets(STDIN));
        text\debug('User input: '.$input);

        /*
         * TODO: Invalid characters:
         * (Windows)    \/:*?"<>|   (check \ and / only at the end of string - need to test)
         * (Linux)      /
         */
        $isInputWrong = is_null($input) || empty($input);

        if ($isInputWrong) {
            echo 'Please input filename: ';
        }
    } while ($isInputWrong);

    return $input;
}

/**
 * Get User confirmation. Default is YES.
 *
 * @param bool $die If true - script dies if User denial
 *
 * @return bool Confirmation result
 */
function getUserConfirm($die = false)
{
    while (1) {
        echo 'Do you really want to continue? [Y/n]: ';

        $input = trim(fgets(STDIN));

        // Default is YES
        if (is_null($input) || empty($input) || strtolower($input) == 'y' || strtolower($input) == 'yes') {
            return true;
        } elseif (strtolower($input) == 'n' || strtolower($input) == 'no') {
            if ($die) {
                die('Script terminated by user.');
            }

            return false;
        }
    }

    // Fix missing return statement warning. Return true...
    return true;
}

/**
 * Prints how much time took some action in milliseconds.
 *
 * @param float $startTime Time when action started
 */
function printEndTime($startTime)
{
    $endTime = microtime(true) - (float) $startTime;
    $endTime = number_format((float) $endTime, 4, '.', '');

    text\text('It was done in '.$endTime.' ms.');
}

/**
 * Execute text() function if DEBUG is set to true.
 *
 * @global bool $DEBUG
 *
 * @param mixed $message Message to print if in DEBUG mode
 *
 * @see text()
 */
/*function debug($message)
{
    if (DEBUG) {
        text($message);
    }
}*/

/**
 * Prints message with new lines.
 *
 * @param mixed $message Message to print
 */
/*function text($message)
{
    echo "\n".$message."\n";
}*/
