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
     * Saves string to file.
     *
     * @param string $string        String to save
     * @param string $filename      Output filename without extension
     * @param string $fileExtension File extension. Default is '.dat'
     *
     * @see Generate::generateRandomNumbers()
     */
    public static function saveStringToFile($string, $filename, $fileExtension = '.dat')
    {
        // Create dir if not exists
        if (!is_dir(dirname($filename))) {
            Text::debug('Creating missing directory: '.dirname($filename));
            mkdir(dirname($filename));
        }

        // Warn about overwriting file
        if (file_exists($filename.$fileExtension)) {
            Text::message('File '.$filename.$fileExtension.' exists and it will be overwritten!');
            Input::dieOnDenyUserConfirm();
        }

        Text::message('Saving to file...');

        $outputFileBytes = file_put_contents($filename.$fileExtension, $string, LOCK_EX);

        Text::message('Output file '.$filename.$fileExtension.' generated with '.$outputFileBytes.' bytes.');
    }
}
