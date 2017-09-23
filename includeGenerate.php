<?php

/*
 * STDIN is already definied. Can be safely deleted?
 * Read PHP < 7.0 documentation
 */
//define("STDIN", fopen ("php://stdin", "r"));

require_once("include.php");

function generateOutputString($min, $max, $decimalPlaces) {
    // TODO: Inform User how long it take
    debug("Generating string.\nMin: ". $min ." Max: ". $max ." DecimalPlaces: ". $decimalPlaces);
    define("GENERATE_START", microtime(true));

    $range = $max - $min;
    $outputString = "";

    // TODO: Calculate output size for generate
    for ($i = 0; $i < 10; $i++) {
        $number = $min + $range * (mt_rand() / mt_getrandmax());
        // Format with trailing zeros ie. 8.00
        $number = number_format((float) $number, $decimalPlaces, '.', '');
        debug($number);
        $outputString .= $number ." ";
    }

    // Remove last space
    return trim($outputString);
}

function getNumberInput($message) {
    echo $message .": ";

    do {
        $input = trim(fgets(STDIN));
        debug("User input: ". $input);

        $isInputWrong = is_null($input) || !is_numeric($input);

        // TODO: Use default numbers?
        if ($isInputWrong) {
            echo "Please input number: ";
        }
    } while ($isInputWrong);

    return $input;
}

function getOutputFilename() {
    echo "Type output filename (without extension): ";

    do {
        $input = trim(fgets(STDIN));
        debug("User input: ". $input);

        /*
         * TODO: Invalid characters:
         * (Windows)    \/:*?"<>|   (check \ and / only at the end of string - need to test)
         * (Linux)      /
         */
        $isInputWrong = is_null($input);

        if ($isInputWrong) {
            echo "Please input filename: ";
        }
    } while ($isInputWrong);

    return $input;
}

function saveStringToFile($string, $filename, $fileExtension = ".dat") {
    // TODO: Create dir if not exists
    // TODO: Warn about overriding file
    debug("Saving generated string to file.");

    $outputFileBytes = file_put_contents($filename . $fileExtension, $string, LOCK_EX);

    text("Output file ". $filename . $fileExtension ." generated with ". $outputFileBytes ." bytes.");

    $endTime = microtime(true) - GENERATE_START;
    $endTime = number_format((float) $endTime, 4, '.', '');
    text("It was done in ". $endTime ." ms.");
}

// Switch Globals min and max if min > max
function checkSwitchGlobalMinMax() {
    if ($GLOBALS["min"] > $GLOBALS["max"]) {
        debug("!!!! Switching min and max in function !!!!");

        $tempMin = $GLOBALS["min"];

        $GLOBALS["min"] = $GLOBALS["max"];
        $GLOBALS["max"] = $tempMin;

        debug("Min: ". $GLOBALS["min"]);
        debug("Max: ". $GLOBALS["max"]);
    }
}
