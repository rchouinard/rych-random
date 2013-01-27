<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Source;

use Rych\Random\SourceInterface;

/**
 * /dev/urandom random data source
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class URandom implements SourceInterface
{

    /**
     * @var string
     */
    protected $file = '/dev/urandom';

    /**
     * Generate a string of random data.
     *
     * @param integer $byteCount The desired number of bytes.
     * @return string Returns the generated string.
     */
    public function getBytes($byteCount)
    {
        $bytes = '';

        if (self::isSupported()) {
            if ($fp = @fopen($this->file, 'rb')) {
                if (function_exists('stream_set_read_buffer')) {
                    stream_set_read_buffer($fp, 0);
                }

                $fileBytes = fread($fp, $byteCount);
                if ($fileBytes) {
                    $bytes = $fileBytes;
                }
            }
        }

        return str_pad($bytes, $byteCount, chr(0));
    }

    /**
     * Test system support for this source.
     *
     * @return boolean Returns true if the source is supported on the current
     *     platform, otherwise false.
     */
    public static function isSupported()
    {
        $supported = false;

        $class = __CLASS__;
        $self = new $class;

        if (file_exists($self->file) && is_readable($self->file)) {
            $supported = true;
        }

        return $supported;
    }

    /**
     * Get the source priority.
     *
     * @return integer Returns an integer indicating the priority of the source.
     *     Lower numbers represent lower priorities.
     */
    public static function getPriority()
    {
        return SourceInterface::PRIORITY_MEDIUM;
    }

}
