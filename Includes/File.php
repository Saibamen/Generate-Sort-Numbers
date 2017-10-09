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
     * Create dir from filename if not exists.
     *
     * @param string $filename Filename
     */
    public static function createMissingDirectory($filename)
    {
        if (!is_dir(dirname($filename))) {
            Text::debug('Creating missing directory: '.dirname($filename));
            mkdir(dirname($filename));
        }
    }

    /**
     * Warn about overwriting file if exists and empty it.
     *
     * @param string $filename      Filename without extension
     * @param string $fileExtension File extension. Default is '.dat'
     *
     * @see Input::dieOnDenyUserConfirm()
     */
    public static function checkIfFileExists($filename, $fileExtension = '.dat')
    {
        if (file_exists($filename.$fileExtension)) {
            Text::message('File '.$filename.$fileExtension.' exists and it will be overwritten!');

            Input::dieOnDenyUserConfirm();

            // Empty the file
            file_put_contents($filename.$fileExtension, '');
        }
    }
}
