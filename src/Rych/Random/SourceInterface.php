<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License  http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random;

/**
 * Source interface
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
interface SourceInterface
{

    /**
     * Low priority source.
     *
     * @var integer
     */
    const PRIORITY_LOW = 1;

    /**
     * Medium priority source.
     *
     * @var integer
     */
    const PRIORITY_MEDIUM = 2;

    /**
     * High priority source.
     *
     * @var integer
     */
    const PRIORITY_HIGH = 3;

    /**
     * Generate a string of random data.
     *
     * @param integer $byteCount The desired number of bytes.
     * @return string Returns the generated string.
     */
    public function getBytes($byteCount);

    /**
     * Test system support for this source.
     *
     * Used as part of the criteria when choosing the best available source.
     * Each source may run a series of tests to determine if it is compatible
     * with the current environment/platform. This may include OS, PHP version,
     * or extension availabilty checks.
     *
     * @return boolean Returns true if the source is supported on the current
     *     platform, otherwise false.
     */
    public static function isSupported();

    /**
     * Get the source priority.
     *
     * Used as part of the criteria when choosing the best available source.
     * Priority is not necessarily an indicator of source strength; in some
     * cases a strong source might be rated with a lower priority simply
     * because it's very slow.
     *
     * @return integer Returns an integer indicating the priority of the source.
     *     Lower numbers represent lower priorities.
     */
    public static function getPriority();

}
