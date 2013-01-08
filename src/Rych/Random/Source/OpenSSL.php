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
 * OpenSSL Source
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class OpenSSL implements Source
{

    /**
     * Class constructor
     *
     * @return void
     * @throws UnsupportedSourceException
     */
    public function __construct()
    {
        if (!extension_loaded('openssl')) {
            throw new UnsupportedSourceException('The openssl extension is not loaded');
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
        return openssl_random_pseudo_bytes($bytes);
    }

}
