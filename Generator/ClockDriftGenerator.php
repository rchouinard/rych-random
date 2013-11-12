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
 * Clock drift algorithm random data generator
 *
 * This generator provides a pure PHP CSPRNG. It gathers entropy by measuring
 * the time it takes to calculate a number of SHA-1 hashes. This is a very slow
 * generator, and it should only be used in cases where better generators are
 * unavailable.
 *
 * Taken from https://github.com/GeorgeArgyros/Secure-random-bytes-in-PHP with
 * permission.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @author George Argyros
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class ClockDriftGenerator implements GeneratorInterface
{

    /**
     * Generate a string of random data.
     *
     * @param  integer $byteCount The desired number of bytes.
     * @return string  Returns the generated string.
     */
    public function generate($byteCount)
    {
        $bitsPerRound = 2;
        $msecPerRound = 400;
        $hashLength = 20;
        $total = $byteCount;
        $generated = '';

        do {
            $bytes = ($total > $hashLength) ? $hashLength : $total;
            $total -= $bytes;

            $entropy = rand() . uniqid(mt_rand(), true);
            $entropy .= implode('', @fstat(@fopen(__FILE__, 'r')));
            $entropy .= memory_get_usage();

            for ($i = 0; $i < 3; $i++) {
                $counter1 = microtime(true);
                $var = sha1(mt_rand());
                for ($j = 0; $j < 50; $j++) {
                    $var = sha1($var);
                }
                $counter2 = microtime(true);
                $entropy .= $counter1 . $counter2;
            }

            $rounds = (int) ($msecPerRound * 50 / (int) (($counter2 - $counter1) * 1000000));
            $iterations = $bytes * (int) (ceil(8 / $bitsPerRound));

            for ($i = 0; $i < $iterations; $i++) {
                $counter1 = microtime();
                $var = sha1(mt_rand());
                for ($j = 0; $j < $rounds; $j++) {
                    $var = sha1($var);
                }
                $counter2 = microtime();
                $entropy .= $counter1 . $counter2;
            }

            $generated .= sha1($entropy, true);
        } while ($byteCount > strlen($generated));

        $bytes = substr($generated, 0, $byteCount);

        return str_pad($bytes, $byteCount, chr(0));
    }

    /**
     * Test system support for this generator.
     *
     * There are no dependencies for this generator, so it's universally
     * supported.
     *
     * @return boolean Returns true if the generator is supported on the current
     *     platform, otherwise false.
     */
    public static function isSupported()
    {
        return true;
    }

    /**
     * Get the generator priority.
     *
     * The algorithm used in this generator is very slow. As such, it has a low
     * priority. Ideally, this generator should only be used as a fallback when
     * no others are available.
     *
     * @return integer Returns an integer indicating the priority of the
     *     generator. Lower numbers represent lower priorities.
     */
    public static function getPriority()
    {
        return GeneratorInterface::PRIORITY_LOW;
    }

}
