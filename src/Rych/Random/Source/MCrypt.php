<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Source;

use Rych\Random\SourceInterface;

/**
 * MCrypt random data source
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class MCrypt implements SourceInterface
{

    /**
     * Generate a string of random data.
     *
     * @param integer $byteCount The desired number of bytes.
     * @return string Returns the generated string.
     */
    public function getBytes($byteCount)
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
     * Test system support for this source.
     *
     * @return boolean Returns true if the source is supported on the current
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
     * Get the source priority.
     *
     * @return integer Returns an integer indicating the priority of the source.
     *     Lower numbers represent lower priorities.
     */
    public static function getPriority()
    {
        return SourceInterface::PRIORITY_HIGH;
    }

}
