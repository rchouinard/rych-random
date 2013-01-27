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
 * Source factory
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class Factory
{

    /**
     * @var array
     */
    private $sources = array ();

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->loadSources();
    }

    /**
     * Get a supported random data source.
     *
     * Checks the available supported sources and attempts to return the best
     * possible source.
     *
     * @return SourceInterface
     * @uses SourceInterface::getPriority() Used to sort the available sources
     *     from lowest to highest priority.
     */
    public function getSource()
    {
        $sources = $this->sources;
        usort($sources, function($a, $b) {
            return ($b::getPriority() - $a::getPriority());
        });
        $class = $sources[0];

        return new $class;
    }

    /**
     * Populate the available sources array.
     *
     * @return void
     * @uses SourceInterface::isSupported() Used to determine if a source is
     *     supported by the system.
     */
    private function loadSources()
    {
        $this->sources = array ();
        $dirIterator = new \DirectoryIterator(__DIR__ . '/Source');
        foreach ($dirIterator as $sourceFile) {
            if ($sourceFile->isFile()) {
                $namespace = __NAMESPACE__;
                $class = "$namespace\\Source\\" . $sourceFile->getBasename('.php');
                if (in_array("$namespace\\SourceInterface", class_implements($class))) {
                    if ($class::isSupported()) {
                        $this->sources[] = $class;
                    }
                }
            }
        }
    }

}
