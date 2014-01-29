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
 * Base32 encoder
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class Base32Encoder implements EncoderInterface
{

    private $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567=';

    /**
     * Encode a string of raw bytes.
     *
     * @param  string $string
     * @return string
     */
    public function encode($string)
    {
        $encoded = '';

        if ($string) {
            $binString = '';

            // Build a binary string representation of the input string
            foreach (str_split($string) as $char) {
                $binString .= str_pad(decbin(ord($char)), 8, 0, STR_PAD_LEFT);
            }

            // Encode the data in 5-bit chunks
            foreach (str_split($binString, 5) as $chunk) {
                $chunk = str_pad($chunk, 5, 0, STR_PAD_RIGHT);
                $encoded .= $this->charset[bindec($chunk)];
            }

            // Add padding to the encoded string as required
            if (strlen($encoded) % 8) {
                $encoded .= str_repeat($this->charset[32], 8 - (strlen($encoded) % 8));
            }
        }

        return $encoded;
    }

    /**
     * Decode an encoded string.
     *
     * @param  string $string
     * @return string
     */
    public function decode($string)
    {
        $decoded = '';
        $string = preg_replace("/[^{$this->charset}]/", '', rtrim(strtoupper($string), $this->charset[32]));

        if ($string) {
            $binString = '';
            foreach (str_split($string) as $char) {
                $binString .= str_pad(decbin(strpos($this->charset, $char)), 5, 0, STR_PAD_LEFT);
            }
            $binString = substr($binString, 0, (floor(strlen($binString) / 8) * 8));

            foreach (str_split($binString, 8) as $chunk) {
                $chunk = str_pad($chunk, 8, 0, STR_PAD_RIGHT);
                $decoded .= chr(bindec($chunk));
            }
        }

        return $decoded;
    }

}

