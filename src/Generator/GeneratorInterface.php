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
 * Generator interface
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
interface GeneratorInterface
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
     * Generate a raw string of random bytes.
     *
     * @param  integer $size
     * @return string
     */
    public function generate($size);

    /**
     * Check if the generated is supported on the current platform.
     *
     * @return boolean Returns true if the generator is supported, false
     *     otherwise.
     */
    public static function isSupported();

    /**
     * Get the generator's priority.
     *
     * Used by the factory in combination with isSupported() to choose the best
     * possible generator for the current platform.
     *
     * @return integer
     */
    public static function getPriority();

}
