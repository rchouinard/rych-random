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
 * Hex encoder
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class HexEncoder implements EncoderInterface
{

    /**
     * Encode a string of raw bytes.
     *
     * @param  string $string
     * @return string
     */
    public function encode($string)
    {
        return bin2hex($string);
    }

    /**
     * Decode an encoded string.
     *
     * @param  string $string
     * @return string
     */
    public function decode($string)
    {
        $string = preg_replace('/[^0-9a-f]/i', '', $string);

        // hex2bin was not introduced until PHP 5.4
        return pack('H*' , $string);
    }

}

