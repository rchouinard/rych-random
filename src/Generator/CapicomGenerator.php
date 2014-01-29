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
 * CAPICOM random data generator
 *
 * Microsoft has deprecated the CAPICOM interface. Please see
 * {@link http://blogs.msdn.com/b/karinm/archive/2009/01/19/capicom-dll-removed-from-windows-sdk-for-windows-7.aspx
 *  the MSDN announcement} for more information.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class CapicomGenerator implements GeneratorInterface
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
            try {
                $util = new \COM('CAPICOM.Utilities.1');
                $capicomBytes = base64_decode($util->GetRandom($byteCount, 0));
                if ($capicomBytes) {
                    $bytes = $capicomBytes;
                }
            } catch (\Exception $e) {
            }
        }

        return str_pad($bytes, $byteCount, chr(0));
    }

    /**
     * Test system support for this generator.
     *
     * This generator is only supported on Windows platforms when the COM
     * extension is loaded.
     *
     * @return boolean Returns true if the generator is supported on the current
     *     platform, otherwise false.
     */
    public static function isSupported()
    {
        $supported = false;
        if ((PHP_OS & "\xDF\xDF\xDF") === 'WIN' && class_exists('\\COM', false)) {
            $supported = true;
        }

        return $supported;
    }

    /**
     * Get the generator priority.
     *
     * CAPICOM has been deprecated by Microsoft, and this generator priority
     * reflects this fact.
     *
     * @return integer Returns an integer indicating the priority of the
     *     generator. Lower numbers represent lower priorities.
     */
    public static function getPriority()
    {
        return GeneratorInterface::PRIORITY_MEDIUM;
    }

}
