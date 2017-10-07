<?php
/**
 * Functions for receiving input from User.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 */

namespace Includes\Input;

use Includes\Text;

/**
 * Get number from User.
 *
 * @param string    $message Message for User what he must type
 * @param int|float $default Default number for empty input. Default is 0
 *
 * @return float Inserted number
 */
function getNumberInput($message, $default = 0)
{
    echo $message.' [Default: '.$default.']: ';

    do {
        $input = trim(fgets(STDIN));
        Text\debug('User input: '.$input);

        if (is_null($input) || empty($input)) {
            Text\debug('Using default input: '.$default);
            $input = $default;
        } elseif (!is_numeric($input)) {
            echo 'Please input number: ';
        }
    } while (!is_numeric($input));

    return (float) $input;
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
        Text\debug('User input: '.$input);

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
 * Terminate script if User denied on confirmation.
 */
function dieOnDenyUserConfirm()
{
    if (!getUserConfirm()) {
        die('Script terminated by user.');
    }
}

/**
 * Get User confirmation. Default is YES.
 *
 * @return bool Confirmation result
 */
function getUserConfirm()
{
    while (1) {
        echo 'Do you really want to continue? [Y/n]: ';

        $input = trim(fgets(STDIN));

        // Default is YES
        if (is_null($input) || empty($input) || strtolower($input) == 'y' || strtolower($input) == 'yes') {
            return true;
        } elseif (strtolower($input) == 'n' || strtolower($input) == 'no') {
            return false;
        }
    }

    // Fix missing return statement warning. Return true...
    return true;
}
