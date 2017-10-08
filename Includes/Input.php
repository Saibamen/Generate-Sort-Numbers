<?php
/**
 * Includes/Input.php.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 * @license MIT
 *
 * @link    https://github.com/Saibamen/Generate-Sort-Numbers
 */

namespace Includes;

/**
 * Functions for receiving input from User.
 */
class Input
{
    /**
     * Get number from User.
     *
     * @param string    $message Message for User what he must type
     * @param int|float $default Default number for empty input. Default is 0
     *
     * @return float Inserted number
     */
    public static function getNumberInput($message, $default = 0)
    {
        echo $message.' [Default: '.$default.']: ';

        do {
            $input = trim(fgets(self::getSTDIN()));

            if (is_null($input) || empty($input)) {
                Text::debug('Using default input: '.$default);
                $input = $default;
            } elseif (!is_numeric($input)) {
                echo 'Please input number: ';
            }
        } while (!is_numeric($input));

        return (float) $input;
    }

    /**
     * Get valid filename from User.
     *
     * @param string $message Message for User what he must type
     * @param string $default Default filename for empty input. Default is 'output'
     *
     * @return string Inserted filename
     */
    public static function getFilenameInput($message, $default = 'output')
    {
        echo $message.' [Default: '.$default.']: ';

        do {
            $input = trim(fgets(self::getSTDIN()));

            /*
             * Invalid characters in files:
             * (Windows)  \/:*?"<>|
             * (Linux)    /
             */

            $lastCharacter = substr($input, -1);

            // Only last character because / and \ are for folders
            $isInputWrong = $lastCharacter === '/' || $lastCharacter === '\\';

            // Running under Windows?
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // https://regex101.com/r/wR5d0J/2/
                $isInputWrong = $isInputWrong || preg_match('/[:*?"<>|]/', $input);
            }

            if (is_null($input) || empty($input)) {
                Text::debug('Using default input: '.$default);
                $input = $default;
            } elseif ($isInputWrong) {
                echo 'Please input valid filename: ';
            }
        } while ($isInputWrong);

        return $input;
    }

    /**
     * Terminate script if User denied on confirmation.
     *
     * @see Input::getUserConfirm()
     */
    public static function dieOnDenyUserConfirm()
    {
        if (!self::getUserConfirm()) {
            die('Script terminated by user.');
        }
    }

    /**
     * Get User confirmation. Default is YES.
     *
     * @return bool Confirmation result
     */
    public static function getUserConfirm()
    {
        while (1) {
            echo 'Do you really want to continue? [Y/n]: ';

            $input = trim(fgets(self::getSTDIN()));

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

    /**
     * Get STDIN for reading User input.
     *
     * This is fix for "STDIN of type string is incompatible with the type
     * resource expected by parameter $handle of fgets()" warning
     *
     * @return resource
     */
    private static function getSTDIN()
    {
        return fopen('php://stdin', 'r');
    }
}
