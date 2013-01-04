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
        $out = '';
        $remaining = $bytes;

        $urand = fopen('/dev/urandom', 'rb');
        stream_set_read_buffer($urand, 0);

        do {
            $read = ($remaining > 20) ? 20 : $remaining;
            $remaining -= $read;

            $entropy = rand() . uniqid(mt_rand(), true);
            $entropy .= implode('', fstat(fopen(__FILE__, 'r')));
            $entropy .= memory_get_usage();
            $entropy .= fread($urand, $read);

            $out .= sha1($entropy, true);
        } while ($bytes > strlen($out));

        fclose($urand);

        return substr($out, 0, $bytes);
    }

}
