<?php

/**
 * @param $message
 */
function debug($message)
{
    if (DEBUG) {
        text($message);
    }
}

/**
 * @param $message
 */
function text($message)
{
    echo "\n".$message."\n";
}
