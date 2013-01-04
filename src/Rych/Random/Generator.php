<?php
/**
 * Ryan Chouinard's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random;

use Rych\Random\Source;

/**
 * Randomness Generator Class
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class Generator
{

    /**
     * @var type \Rych\Random\Source
     */
    private $source;

    /**
     * @param \Rych\Random\Source $source
     * @return void
     */
    public function __construct(Source $source = null)
    {
        $this->source = $source;
    }

    /**
     * @param \Rych\Random\Source $source
     * @return self
     */
    public function setSource(Source $source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return \Rych\Random\Source
     */
    public function getSource()
    {
        // Kind of a hack for now; this needs to be more dynamic.
        if (!$this->source) {
            if (extension_loaded('openssl')) {
                $this->source = new \Rych\Random\Source\OpenSSL;
            } else if (extension_loaded('mcrypt')) {
                $this->source = new \Rych\Random\Source\MCrypt;
            } else if (extension_loaded('com_dotnet')) {
                $this->source = new \Rych\Random\Source\CAPICOM;
            } else if (is_readable('/dev/urandom')) {
                $this->source = new \Rych\Random\Source\URandom;
            } else {
                $this->source = new \Rych\Random\Source\MTRand;
            }
        }

        return $this->source;
    }

    /**
     * @param integer $bytes
     * @return string
     */
    public function generate($bytes)
    {
        $source = $this->getSource();
        return $source->read($bytes);
    }

}
