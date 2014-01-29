<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random;

use Rych\Random\Encoder\EncoderInterface;
use Rych\Random\Generator\GeneratorInterface;

/**
 * Random data main class
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class Random
{

    /**
     * @var \Rych\Random\Encoder\EncoderInterface
     */
    protected $encoder;

    /**
     * @var \Rych\Random\GeneratorInterface
     */
    protected $generator;

    /**
     * Class constructor.
     *
     * @param  \Rych\Random\Generator\GeneratorInterface $generator
     * @param  \Rych\Random\Encoder\EncoderInterface     $encoder
     * @return void
     */
    public function __construct(GeneratorInterface $generator = null, EncoderInterface $encoder = null)
    {
        if (!$encoder) {
            // Really just a pass-thru "encoder"
            $encoder = new Encoder\RawEncoder;
        }

        if (!$generator) {
            $factory = new Generator\GeneratorFactory;
            $generator = $factory->getGenerator();
        }

        $this->setEncoder($encoder);
        $this->setGenerator($generator);
    }

    /**
     * Get the currently registered encoder instance.
     *
     * @return \Rych\Random\Encoder\EncoderInterface
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * Set an encoder instance.
     *
     * @param  \Rych\Random\Encoder\EncoderInterface $encoder
     * @return \Rych\Random\Random
     */
    public function setEncoder(Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;

        return $this;
    }

    /**
     * Get the currently registered generator instance.
     *
     * @return \Rych\Random\Generator\GeneratorInstance
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Set a generator instance.
     *
     * @param  \Rych\Random\Generator\GeneratorInterface $generator
     * @return \Rych\Random\Random
     */
    public function setGenerator(Generator\GeneratorInterface $generator)
    {
        $this->generator = $generator;

        return $this;
    }

    /**
     * Get a random raw byte string of the specified length.
     *
     * @param  integer $length The length of the requested string.
     * @return string  A random raw byte string of the specified length.
     */
    public function getRandomBytes($length)
    {
        return $this->encoder->encode($this->generator->generate($length));
    }

    /**
     * Get a random integer within the specified range.
     *
     * @param  integer $min The minimum expected value. Defaults to 0.
     * @param  integer $max The maximum expected value. Defaults to PHP_INT_MAX.
     * @return integer A random integer between the specified values, inclusive.
     */
    public function getRandomInteger($min = 0, $max = PHP_INT_MAX)
    {
        $min = (int) $min;
        $max = (int) $max;
        $range = $max - $min;

        $bits  = $this->getBitsInInteger($range);
        $bytes = $this->getBytesInBits($bits);
        $mask  = (int) ((1 << $bits) - 1);

        do {
            $byteString = $this->generator->generate($bytes);
            $result = hexdec(bin2hex($byteString)) & $mask;
        } while ($result > $range);

        return (int) $result + $min;
    }

    /**
     * Get a random string of the specified length.
     *
     * @param  integer $length The length of the requested string.
     * @return string  A random string of the specified length, consisting of
     *     characters from the base64 character set.
     */
    public function getRandomString($length, $charset = null)
    {
        $length = (int) $length;
        if (!$charset) {
            $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        }

        $charsetLength = strlen($charset);
        $neededBytes = $this->getBytesInBits($length * ($this->getBitsInInteger($charsetLength) + 1));

        $string = '';
        do {
            $byteString = $this->generator->generate($neededBytes);
            for ($i = 0; $i < $neededBytes; ++$i) {
                if (ord($byteString[$i]) > (255 - (255 % $charsetLength))) {
                    continue;
                }
                $string .= $charset[ord($byteString[$i]) % $charsetLength];
            }
        } while (strlen($string) < $length);

        return substr($string, 0, $length);
    }

    /**
     * Determine the number of bits required to represent a given number.
     *
     * For example, the number 64 can be represented in 7 bits (0b1000000),
     * so this method would return 7.
     *
     * @param  integer $number
     * @return integer
     */
    protected function getBitsInInteger($number)
    {
        if ($number == 0) {
            return 0;
        }

        $bits = 1;
        while ($number >>= 1) {
            ++$bits;
        }

        return $bits;
    }

    /**
     * Determine the number of bytes in the specified number of bits.
     *
     * @param  integer $bits
     * @return integer
     */
    protected function getBytesInBits($bits)
    {
        return (int) ceil($bits / 8);
    }

}
