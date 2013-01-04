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
 * MTRand Source
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class MTRand implements Source
{

    /**
     * Read a raw random string from the generator source.
     *
     * @param integer $bytes The number of bytes to read from the source.
     * @return string A random string of bytes of the specified length.
     */
    public function read($bytes)
    {
        $output = '';
        while (strlen($output) < $bytes) {
            $block = '';
            for ($i = 0; $i < 64; ++$i) {
                $block .= chr((mt_rand() ^ mt_rand()) % 256);
            }
            $output .= sha1($block, true);
        }
        return substr($output, 0, $bytes);
    }

}
