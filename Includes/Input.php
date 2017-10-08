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
            $input = trim(fgets(STDIN));

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
     * Get filename from User.
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
            $input = trim(fgets(STDIN));

            /*
             * TODO: Invalid characters:
             * (Windows)    \/:*?"<>|   (check \ and / only at the end of string - need to test)
             * (Linux)      /
             */
            $isInputWrong = substr($input, -1) === '/';

            if (is_null($input) || empty($input)) {
                Text::debug('Using default input: '.$default);
                $input = $default;
            } elseif ($isInputWrong) {
                echo 'Please input filename: ';
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
}
