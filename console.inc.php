<?php
/**
 * Functions for console scripts.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 */

/**
 * Saves string to file.
 *
 * @param string $string        String to save
 * @param string $filename      Output filename without extension
 * @param string $fileExtension File extension. Default is '.dat'
 *
 * @see generateRandomNumbers()
 */
function saveStringToFile($string, $filename, $fileExtension = '.dat')
{
    // Create dir if not exists
    if (!is_dir(dirname($filename))) {
        debug('Creating missing directory: '.dirname($filename));
        mkdir(dirname($filename));
    }

    // Warn about overwriting file
    if (file_exists($filename.$fileExtension)) {
        text('File '.$filename.$fileExtension.' exists and it will be overwritten!');
    }

    text('Saving to file...');

    $outputFileBytes = file_put_contents($filename.$fileExtension, $string, LOCK_EX);

    text('Output file '.$filename.$fileExtension.' generated with '.$outputFileBytes.' bytes.');
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
        debug('User input: '.$input);

        /*
         * TODO: Invalid characters:
         * (Windows)    \/:*?"<>|   (check \ and / only at the end of string - need to test)
         * (Linux)      /
         */
        $isInputWrong = is_null($input);

        if ($isInputWrong) {
            echo 'Please input filename: ';
        }
    } while ($isInputWrong);

    return $input;
}

/**
 * Prints how much time took some action in milliseconds
 *
 * @param float $startTime Time when action started
 */
function printEndTime($startTime)
{
    $endTime = microtime(true) - (float) $startTime;
    $endTime = number_format((float) $endTime, 4, '.', '');

    text('It was done in '.$endTime.' ms.');
}

/**
 * Execute text() function if DEBUG is set to true.
 *
 * @global bool $DEBUG
 *
 * @param string $message Message to print if in DEBUG mode
 *
 * @see text()
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
 * @param string $message Message to print
 */
function text($message)
{
    echo "\n".$message."\n";
}
