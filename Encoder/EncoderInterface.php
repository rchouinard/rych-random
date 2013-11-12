<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Encoder;

/**
 * Encoder interface
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
interface EncoderInterface
{

    /**
     * Encode a string of raw bytes.
     *
     * @param  string $string
     * @return string
     */
    public function encode($string);

    /**
     * Decode an encoded string.
     *
     * @param  string $string
     * @return string
     */
    public function decode($string);

}

