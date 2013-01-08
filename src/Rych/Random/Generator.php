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
            // Default, no special requirements or dependencies.
            $this->source = new \Rych\Random\Source\Native;

            // Windows platform preferrences
            if (PHP_OS & "\xDF\xDF\xDF" == 'WIN') {
                if (extension_loaded('com_dotnet')) {
                    $this->source = new \Rych\Random\Source\CAPICOM;
                } if (extension_loaded('mcrypt')) {
                    $this->source = new \Rych\Random\Source\MCrypt;
                // openssl_random_pseudo_bytes() on windows pre-php 5.3.4
                // has potential blocking behavior, so we avoid it. After
                // php 5.3.4, openssl_random_pseudo_bytes() is essentially
                // the same as mcrypt_create_iv(). I'm only using it here in
                // case mcrypt is not available but openssl is.
                } else if (extension_loaded('openssl') && version_compare(PHP_VERSION, '5.3.4', '>=')) {
                    $this->source = new \Rych\Random\Source\OpenSSL;
                }
            } else {
                if (extension_loaded('openssl')) {
                    $this->source = new \Rych\Random\Source\OpenSSL;
                } else if (is_readable('/dev/urandom')) {
                    $this->source = new \Rych\Random\Source\DevURandom;
                // mcrypt_create_iv() with MCRYPT_DEV_URANDOM, as used in this
                // source, basically reads from /dev/urandom but much slower
                // than doing so directly. This is included in case we can't
                // read /dev/urandom directly for some reason.
                } else if (extension_loaded('mcrypt')) {
                    $this->source = new \Rych\Random\Source\MCrypt;
                }
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
