<?php
/**
 * Includes/Text.php.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 * @license MIT
 *
 * @link    https://github.com/Saibamen/Generate-Sort-Numbers
 */

namespace Includes;

/**
 * Functions for printing text.
 */
class Text
{
    /**
     * @var bool If true - print more information.
     */
    private static $debugMode = false;

    /**
     * Prints how much time took some action in milliseconds.
     *
     * @param float|string $startTime Time when action started
     */
    public static function printTimeDuration($startTime)
    {
        $currentTime = microtime(true);

        if (gettype($startTime) === 'string') {
            $currentTime = microtime();
        }

        $completedIn = (float) $currentTime - (float) $startTime;
        $completedIn = number_format((float) $completedIn, 4, '.', '');

        self::message('It was done in '.$completedIn.' ms.');
    }

    /**
     * Set $debugMode property value.
     *
     * @param bool $value
     *
     * @see Text::$debugMode
     */
    public static function setDebug($value)
    {
        self::$debugMode = $value;
    }

    /**
     * Get $debugMode property value.
     *
     * @return bool
     *
     * @see Text::$debugMode
     */
    public static function getDebug()
    {
        return self::$debugMode;
    }

    /**
     * Execute message() function if $debugMode is set to true.
     *
     * @param mixed $message Message to print if in DEBUG mode
     *
     * @see Text::$debugMode
     * @see Text::message()
     */
    public static function debug($message)
    {
        if (self::$debugMode) {
            self::message($message);
        }
    }

    /**
     * Prints message with new lines.
     *
     * @param mixed $message Message to print
     */
    public static function message($message)
    {
        echo "\n".$message."\n";
    }
}
