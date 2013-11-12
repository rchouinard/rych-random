<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Generator;

/**
 * /dev/urandom random data generator
 *
 * This generator simply reads from /dev/urandom. it is only supported on
 * non-Windows platforms which provide the interface.
 *
 * The /dev/urandom special file provides a stream of cryptographically secure
 * pseudo-random bytes. It is the non-blocking version of /dev/random. More
 * information may be found at {@link http://en.wikipedia.org/wiki//dev/random
 * Wikipedia}.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class URandomGenerator implements GeneratorInterface
{

    /**
     * @var string
     */
    protected $file = '/dev/urandom';

    /**
     * Generate a string of random data.
     *
     * @param  integer $byteCount The desired number of bytes.
     * @return string  Returns the generated string.
     */
    public function generate($byteCount)
    {
        $bytes = '';

        if (self::isSupported()) {
            if ($fp = @fopen($this->file, 'rb')) {
                if (function_exists('stream_set_read_buffer')) {
                    stream_set_read_buffer($fp, 0);
                }

                $fileBytes = fread($fp, $byteCount);
                if ($fileBytes) {
                    $bytes = $fileBytes;
                }
            }
        }

        return str_pad($bytes, $byteCount, chr(0));
    }

    /**
     * Test system support for this generator.
     *
     * @return boolean Returns true if the generator is supported on the current
     *     platform, otherwise false.
     */
    public static function isSupported()
    {
        $supported = false;

        $class = __CLASS__;
        $self = new $class;

        if (file_exists($self->file) && is_readable($self->file)) {
            $supported = true;
        }

        return $supported;
    }

    /**
     * Get the generator priority.
     *
     * @return integer Returns an integer indicating the priority of the
     *     generator. Lower numbers represent lower priorities.
     */
    public static function getPriority()
    {
        return GeneratorInterface::PRIORITY_MEDIUM;
    }

}
