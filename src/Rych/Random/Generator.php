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

/**
 * Generator
 *
 * This class is a convenience class as a simple interface to the library.
 * Just instantiate the class and it will select the best built-in data source
 * via the {@link Factory} class.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class Generator
{

    /**
     * @var SourceInterface
     */
    private $source;

    /**
     * Class constructor.
     *
     * @param SourceInterface $source A valid instance of SourceInterface.
     * @return void
     */
    public function __construct(SourceInterface $source = null)
    {
        if ($source) {
            $this->setSource($source);
        }
    }

    /**
     * Get the currently registered source.
     *
     * If a source is not registered, the best available source will be selected
     * by {@link Factory}.
     *
     * @return SourceInterface Returns the currently registered source.
     * @uses Factory Used if a source has not been previously registered.
     */
    public function getSource()
    {
        if (!$this->source) {
            $factory = new Factory;
            $this->setSource($factory->getSource());
        }

        return $this->source;
    }

    /**
     * Register a source.
     *
     * @param SourceInterface $source A valid instance of SourceInterface.
     * @return self
     */
    public function setSource(SourceInterface $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Generate a string of random data.
     *
     * @param integer $byteCount The desired number of bytes.
     * @return string Returns the generated string.
     */
    public function generate($byteCount)
    {
        return $this->getSource()->getBytes($byteCount);
    }

}
