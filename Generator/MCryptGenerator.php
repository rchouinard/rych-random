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
 * MCrypt random data generator
 *
 * This generator provides an interface to the mcrypt extension. The extension
 * simply wraps the operating system's built-in CSPRNG. On Windows platforms,
 * that means using Microsoft's CryptoAPI. Non-Windows platforms will read from
 * /dev/urandom.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class MCryptGenerator implements GeneratorInterface
{

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
            $mcryptStr = mcrypt_create_iv($byteCount, MCRYPT_DEV_URANDOM);
            if ($mcryptStr !== false) {
                $bytes = $mcryptStr;
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
        if (function_exists('mcrypt_create_iv')) {
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
        return GeneratorInterface::PRIORITY_HIGH;
    }

}
