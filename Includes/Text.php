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
 * @param float $startTime Time when action started
 */
function printEndTime($startTime)
{
    $endTime = microtime(true) - (float) $startTime;
    $endTime = number_format((float) $endTime, 4, '.', '');

    message('It was done in '.$endTime.' ms.');
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