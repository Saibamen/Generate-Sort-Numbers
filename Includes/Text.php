<?php
/**
 * Functions for printing text.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 */

namespace Includes\Text;

/**
 * Prints how much time took some action in milliseconds.
 *
 * @param float|string $startTime Time when action started
 */
function printTimeDuration($startTime)
{
    if (gettype($startTime) === 'string') {
        $currentTime = microtime();
    } else {
        $currentTime = microtime(true);
    }

    $completedIn = (float) $currentTime - (float) $startTime;
    $completedIn = number_format((float) $completedIn, 4, '.', '');

    message('It was done in '.$completedIn.' ms.');
}

/**
 * Execute message() function if DEBUG is set to true.
 *
 * @global bool $DEBUG
 *
 * @param mixed $message Message to print if in DEBUG mode
 *
 * @see \Includes\Text\message()
 */
function debug($message)
{
    if (DEBUG) {
        message($message);
    }
}

/**
 * Prints message with new lines.
 *
 * @param mixed $message Message to print
 */
function message($message)
{
    echo "\n".$message."\n";
}
