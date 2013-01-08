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
 * /dev/urandom Source
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class DevURandom implements Source
{

    /**
     * @var string
     */
    protected $source = '/dev/urandom';

    /**
     * @var resource
     */
    private $handle;

    /**
     * Class constructor
     *
     * @return void
     * @throws UnsupportedSourceException
     */
    public function __construct()
    {
        $src = $this->source;
        if (!file_exists($src) || !is_readable($src)) {
            throw new UnsupportedSourceException("Cannot read from '$src'");
        }

        $this->handle = @fopen($src, 'rb');
        if (!$this->handle) {
            throw new UnsupportedSourceException("Could not open '$src' for reading");
        } else if (function_exists('stream_set_read_buffer')) {
            stream_set_read_buffer($this->handle, 0);
        }
    }

    /**
     * Class destructor
     *
     * @return void
     */
    public function __destruct()
    {
        if ($this->handle) {
            fclose($this->handle);
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
        return fread($this->handle, $bytes);
    }

}
