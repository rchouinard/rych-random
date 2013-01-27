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

    public function __construct(SourceInterface $source = null)
    {
        if ($source) {
            $this->setSource($source);
        }
    }

    public function getSource()
    {
        if (!$this->source) {
            $factory = new Factory;
            $this->setSource($factory->getSource());
        }

        return $this->source;
    }

    public function setSource(SourceInterface $source)
    {
        $this->source = $source;

        return $this;
    }

    public function generate($byteCount)
    {
        return $this->getSource()->getBytes($byteCount);
    }

}
