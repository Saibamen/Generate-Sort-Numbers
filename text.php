<?php

namespace generate_sort_numbers\text;

/**
 * Execute text() function if DEBUG is set to true.
 *
 * @global bool $DEBUG
 *
 * @param mixed $message Message to print if in DEBUG mode
 *
 * @see generate_sort_numbers\text\text()
 */
function debug($message)
{
    if (DEBUG) {
        text($message);
    }
}

/**
 * Prints message with new lines.
 *
 * @param mixed $message Message to print
 */
function text($message)
{
    echo "\n".$message."\n";
}
