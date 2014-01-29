<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace My\Custom\Generator;

use Rych\Random\Generator\GeneratorInterface;

/**
 * Mock generator for testing
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class TestGenerator implements GeneratorInterface
{

    public function generate($size)
    {
        return str_repeat(chr(0), $size);
    }

    public static function isSupported()
    {
        return true;
    }

    public static function getPriority()
    {
        return GeneratorInterface::PRIORITY_HIGH;
    }

}

