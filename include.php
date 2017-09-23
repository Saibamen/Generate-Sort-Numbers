<?php

function debug($message)
{
    if (DEBUG) {
        text($message);
    }
}

function text($message)
{
    echo "\n".$message."\n";
}
