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
 * OpenSSL random data source
 *
 * This source requires the OpenSSL extension to be loaded in order to work.
 * It should be noted that this source does require PHP versions >= 5.3.7 on
 * Windows, due to a bug in the OpenSSL extension which could lead to very
 * slow performance or hangs under some circumstances.
 *
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class OpenSSL implements SourceInterface
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
            $sslStrong = false;
            $sslBytes = openssl_random_pseudo_bytes($byteCount, $sslStrong);
            if ($sslStrong) {
                $bytes = $sslBytes;
            }
            unset ($sslStrong);
        }

        return str_pad($bytes, $byteCount, chr(0));
    }

    /**
     * Test system support for this source.
     *
     * PHP versions prior to 5.3.7 have a bug in the Windows implementation of
     * this source. The implementation used OpenSSL functions which could cause
     * blocking for an indefinite period of time on headless non-interactive
     * Windows servers. Because of this, the source is not supported for PHP
     * versions < 5.3.7 on Windows.
     *
     * The OpenSSL function this source uses simply wraps Microsoft's CryptoAPI
     * on PHP versions >= 5.3.7 on Windows. It should be noted that this is also
     * exactly how the MCrypt source operates on Windows.
     *
     * @return boolean Returns true if the source is supported on the current
     *     platform, otherwise false.
     */
    public static function isSupported()
    {
        $supported = false;
        if (function_exists('openssl_random_pseudo_bytes')) {
            if (version_compare(PHP_VERSION, '5.3.7') >= 0 || (PHP_OS & "\xDF\xDF\xDF") !== 'WIN') {
                $supported = true;
            }
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
