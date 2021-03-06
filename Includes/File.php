<?php
/**
 * Includes/File.php.
 *
 * @author  Adam "Saibamen" Stachowicz <saibamenppl@gmail.com>
 * @license MIT
 *
 * @link    https://github.com/Saibamen/Generate-Sort-Numbers
 */

namespace Includes;

/**
 * Functions for operating on files.
 */
class File
{
    /**
     * Save array to file.
     *
     * @param array        $array         Array to sort
     * @param string       $filename      Filename without extension
     * @param string       $fileExtension File extension. Default is '.dat'
     * @param string|mixed $delimiter     Delimiter. Default is ' '
     */
    public static function saveArrayToFile($array, $filename, $fileExtension = '.dat', $delimiter = ' ')
    {
        $chunkSize = 20;
        $chunkedArray = array_chunk($array, $chunkSize);
        $chunkedArrayCount = count($chunkedArray);

        Text::message('Saving to file...');

        $saveStart = microtime(true);

        $file = fopen($filename.$fileExtension, 'w');
        $outputString = null;
        $currentArrayItem = 0;

        foreach ($chunkedArray as $chunk) {
            foreach ($chunk as $value) {
                $outputString .= $value.$delimiter;
            }

            // Remove last delimiter
            if (++$currentArrayItem === $chunkedArrayCount) {
                $outputString = rtrim($outputString, $delimiter);
            }

            fwrite($file, $outputString);
            $outputString = null;
        }

        fclose($file);

        Text::printTimeDuration($saveStart);
        Text::message('Output file '.$filename.$fileExtension.' saved with '.filesize($filename.$fileExtension).' bytes.');
    }

    /**
     * Warn about overwriting file if exists and empty it.
     *
     * @param string $filename      Filename without extension
     * @param string $fileExtension File extension. Default is '.dat'
     *
     * @see Input::dieOnDenyUserConfirm()
     */
    public static function checkIfFileExistsAndDeleteContent($filename, $fileExtension = '.dat')
    {
        if (file_exists($filename.$fileExtension)) {
            Text::message('File '.$filename.$fileExtension.' exists and it will be overwritten!');

            Input::dieOnDenyUserConfirm();

            // Empty the file
            file_put_contents($filename.$fileExtension, '');
        }
    }

    /**
     * Create dir from filename if not exists.
     *
     * @param string $filename Filename
     */
    public static function createMissingDirectory($filename)
    {
        if (!is_dir(dirname($filename))) {
            Text::debug('Creating missing directory: '.dirname($filename));
            mkdir(dirname($filename), 0777, true);
        }
    }

    /**
     * Get array from file content.
     *
     * @param string       $filename      Filename without extension
     * @param string       $fileExtension File extension. Default is '.dat'
     * @param string|mixed $delimiter     Delimiter. Default is ' '
     *
     * @return array
     */
    public static function getArrayFromFile($filename, $fileExtension = '.dat', $delimiter = ' ')
    {
        $array = array();

        if (file_exists($filename.$fileExtension)) {
            $array = explode($delimiter, file_get_contents($filename.$fileExtension));
        }

        return $array;
    }
}
