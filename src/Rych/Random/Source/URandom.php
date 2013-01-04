<?php
/**
 * Ryan Chouinard's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Source;

use Rych\Random\Source;
use Rych\Random\Exception\UnsupportedSourceException;

/**
 * URandom Source
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class URandom implements Source
{

    /**
     * @return void
     * @throws UnsupportedSourceException
     */
    public function __construct()
    {
        if (!file_exists('/dev/urandom') || !is_readable('/dev/urandom')) {
            throw new UnsupportedSourceException('Cannot read from /dev/urandom');
        }
    }

    /**
     * Read a raw random string from the generator source.
     *
     * @param integer $bytes The number of bytes to read from the source.
     * @return string A random string of bytes of the specified length.
     */
    public function read($bytes)
    {
        $handle = fopen('/dev/urandom', 'rb');
        if ($handle && function_exists('stream_set_read_buffer')) {
            stream_set_read_buffer($handle, 0);
        }

        $data = fread($handle, $bytes);

        fclose($handle);
        return $data;
    }

}
