<?php

/**
 * Includes simple functions for printing text.
 *
 * @package Saibamen/Generate-Sort-Numbers
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 */

/**
 * Execute {@see text()} function if DEBUG is set to true.
 *
 * @global bool $DEBUG
 * @param $message
 * @see text()
 */
function debug($message)
{
    if (DEBUG) {
        text($message);
    }
}

/**
 * Prints $message with new lines.
 *
 * @param $message
 */
function text($message)
{
    echo "\n".$message."\n";
}
