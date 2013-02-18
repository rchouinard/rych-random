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
 * This class provides a method to select the best available random source.
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
     * @var array
     */
    private $sourcePaths = array ();

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addSourcePath(__NAMESPACE__ . '\\Source', __DIR__ . '/Source');
        $this->loadSources();
    }

    /**
     * Add a search path for custom sources.
     *
     * @param string $prefix Namespace prefix used by source classes
     *     in this path.
     * @param string $path Directory path containing source classes.
     * @return boolean Returns true on success, false otherwise.
     */
    public function addSourcePath($prefix, $path)
    {
        $path = realpath($path);
        $success = false;
        if ($path && !array_key_exists($prefix, $this->sourcePaths)) {
            $this->sourcePaths[$prefix] = $path;
            $success = true;
        }

        return $success;
    }

    /**
     * Clear all registered source paths.
     *
     * @return self Returns an instance of self for method chaining.
     */
    public function clearSourcePaths()
    {
        $this->sourcePaths = array ();

        return $this;
    }

    /**
     * Get all registered source paths.
     *
     * @return array An associative array of registered paths, using the prefix
     *     as a key.
     */
    public function getSourcePaths()
    {
        return $this->sourcePaths;
    }

    /**
     * Remove a registered source path.
     *
     * @param type $prefixOrPath The prefix or directory path to remove.
     * @return self Returns an instance of self for method chaining.
     */
    public function removeSourcePath($prefixOrPath)
    {
        if (array_key_exists($prefixOrPath, $this->sourcePaths)) {
            $prefix = $prefixOrPath;
            unset($this->sourcePaths[$prefix]);
        } else if (($prefixOrPath = realpath($prefixOrPath)) && in_array($prefixOrPath, $this->sourcePaths)) {
            $path = $prefixOrPath;
            $sourcePaths = $this->sourcePaths;
            $this->sourcePaths = array_filter($sourcePaths, function ($value) use ($path) {
                return ($value != $path);
            });
        }

        return $this;
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

        $source = null;
        if (isset ($sources[0])) {
            $class = $sources[0];
            $source = new $class;
        }

        return $source;
    }

    /**
     * Populate the available sources array.
     *
     * @return void
     * @uses SourceInterface::isSupported() Used to determine if a source is
     *     supported by the system.
     */
    public function loadSources()
    {
        // Reset the list of loaded classes
        $this->sources = array ();

        // Loop through each registered path
        foreach ($this->sourcePaths as $sourcePrefix => $sourcePath) {
            // Build the iterators to search the path
            $dirIterator = new \RecursiveDirectoryIterator($sourcePath);
            $iteratorIterator = new \RecursiveIteratorIterator($dirIterator);
            $sourceIterator = new \RegexIterator($iteratorIterator, '/^.+\.php$/i');

            // Loop through the iterator looking for SourceInterface instances
            foreach ($sourceIterator as $sourceFile) {
                // Determine additional namespace from file path
                $pathName = $sourceFile->getPath();
                if (substr($pathName, 0, strlen($sourcePath)) == $sourcePath) {
                    $pathName = substr($pathName, strlen($sourcePath), strlen($pathName));
                }

                // Best guess for class name is Prefix\Path\File
                $class = $sourcePrefix . '\\' . $pathName . $sourceFile->getBasename('.php');
                $class = str_replace('/', '\\', $class);

                // If the class doesn't exists and isn't autoloaded, try to
                // load it from the discovered file.
                if (!class_exists($class, true)) {
                    include $sourceFile->getPathname();
                }

                // If the class exists and implements SourceInterface,
                // append it to our list.
                if (class_exists($class, false) && in_array(__NAMESPACE__ . '\\SourceInterface', class_implements($class))) {
                    if ($class::isSupported()) {
                        $this->sources[] = $class;
                    }
                }
            }
        }
    }

}
