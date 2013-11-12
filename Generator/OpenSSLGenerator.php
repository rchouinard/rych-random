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
 * OpenSSL random data generator
 *
 * This generator provides an interface to the openssl extension. On most
 * platforms, the extension will use the CSPRNG provided by the OpenSSL library.
 * Due to a bug in the extension, this generator is unavailable on PHP
 * versions < 5.3.7 on Windows platforms. These buggy versions attempted to
 * gather additional entropy from an attached display device. While this worked
 * fine on workstations, this would cause headless servers to run very slowly
 * or hang.
 *
 * The behavior of the openssl extension on Windows was modified further
 * starting with PHP 5.4.0 to bypass the OpenSSL CSPRNG completely and use
 * Windows' built-in CSPRNG instead via Microsoft's CryptoAPI.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class OpenSSLGenerator implements GeneratorInterface
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
     * Test system support for this generator.
     *
     * PHP versions prior to 5.3.7 have a bug in the Windows implementation of
     * this generator. The implementation used OpenSSL functions which could
     * cause blocking for an indefinite period of time on headless
     * non-interactive Windows servers. Because of this, the generator is not
     * supported for PHP versions < 5.3.7 on Windows.
     *
     * The OpenSSL function this generator uses simply wraps Microsoft's
     * CryptoAPI on PHP versions >= 5.4.0 on Windows. It should be noted that
     * this is also exactly how the MCrypt generator operates on Windows.
     *
     * @return boolean Returns true if the generator is supported on the current
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
