<?php
/**
 * Ryan Chouinard's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Source;

use Rych\Random\Source;

/**
 * Native Source
 *
 * Adapted from https://github.com/GeorgeArgyros/Secure-random-bytes-in-PHP
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class Native implements Source
{

    /**
     * @var boolean
     */
    private $useURandom = false;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->setUseURandom(is_readable('/dev/urandom'));
    }

    /**
     * @param boolean $flag
     * @return \Rych\Random\Source\Native
     */
    public function setUseURandom($flag)
    {
        $this->useURandom = (bool) $flag;
        return $this;
    }

    /**
     * Read a raw random string from the generator source.
     *
     * @param integer $bytes The number of bytes to read from the source.
     * @return string A random string of bytes of the specified length.
     */
    public function read($bytes)
    {
        $output = '';
        $bitsPerRound = 2;
        $msecPerRound = 400;
        $total = $length = $bytes;

        $handle = false;
        if ($this->useURandom) {
            $handle = @fopen('/dev/urandom', 'rb');
        }

        if ($handle && function_exists('stream_set_read_buffer')) {
            stream_set_read_buffer($handle, 0);
        }

        do {
            $bytes = ($total > 20) ? 20 : $total;
            $total -= $bytes;

            $entropy = rand() . uniqid(mt_rand(), true);
            $entropy .= implode('', @fstat(@fopen( __FILE__, 'r')));
            $entropy .= memory_get_usage();

            if ($handle) {
                $entropy .= fread($handle, $bytes);
            } else {
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
                $iter = $bytes * (int) (ceil(8 / $bitsPerRound));
                for ($i = 0; $i < $iter; $i++) {
                    $counter1 = microtime();
                    $var = sha1(mt_rand());
                    for ($j = 0; $j < $rounds; $j++) {
                       $var = sha1($var);
                    }
                    $counter2 = microtime();
                    $entropy .= $counter1 . $counter2;
                }
            }

            $output .= sha1($entropy, true);
        } while ($length > strlen($output));

        if ($handle) {
            fclose($handle);
        }

       return substr($output, 0, $length);
    }

}
