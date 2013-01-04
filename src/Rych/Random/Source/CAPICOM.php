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
use Rych\Random\Exception\UnsupportedSourceException;

/**
 * CAPICOM Source
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class CAPICOM implements Source
{

    /**
     * @return void
     * @throws UnsupportedSourceException
     */
    public function __construct()
    {
        if (!extension_loaded('com_dotnet')) {
            throw new UnsupportedSourceException('The COM/.Net extension is not loaded');
        }
    }

    /**
     * Read a raw random string from the generator source.
     *
     * @param integer $bytes The number of bytes to read from the source.
     * @return string A random string of bytes of the specified length.
     */
    public function read($bytes)
    {
        $util = new \COM('CAPICOM.Utilities.1');
        $data = base64_decode($util->GetRandom($bytes, 0));

        return str_pad($data, $bytes, chr(0));
    }

}
