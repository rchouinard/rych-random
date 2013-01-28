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
 * Mock random data source
 *
 * This source is used in testing. It always reports that it is not supported,
 * so it cannot be picked up by the factory automatically.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class Mock implements SourceInterface
{

    /**
     * @var string
     */
    private $randomString;

    /**
     * Set the expected fake random data to return.
     *
     * @param string $string
     * @return void
     */
    public function setMockString($string)
    {
        $this->randomString = $string;
    }

    /**
     * Generate a string of random data.
     *
     * @param integer $byteCount The desired number of bytes.
     * @return string Returns the generated string.
     */
    public function getBytes($byteCount)
    {
        $bytes = '';

        if (strlen(!$this->randomString)) {
            $this->randomString = chr(0);
        }

        do {
            $bytes .= $this->randomString;
        } while (strlen($bytes) < $byteCount);

        return substr($bytes, 0, $byteCount);
    }

    /**
     * Test system support for this source.
     *
     * @return boolean Returns true if the source is supported on the current
     *     platform, otherwise false.
     */
    public static function isSupported()
    {
        return false;
    }

    /**
     * Get the source priority.
     *
     * @return integer Returns an integer indicating the priority of the source.
     *     Lower numbers represent lower priorities.
     */
    public static function getPriority()
    {
        return SourceInterface::PRIORITY_LOW;
    }

}
