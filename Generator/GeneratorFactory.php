<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Generator;

/**
 * Generator factory
 *
 * This class provides a method to select the best available random generator.
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class GeneratorFactory
{

    /**
     * @var array
     */
    private $generators = array ();

    /**
     * @var array
     */
    private $generatorPaths = array ();

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addGeneratorPath(__NAMESPACE__, __DIR__);
    }

    /**
     * Add a search path for custom generators.
     *
     * @param string $prefix Namespace prefix used by generator classes
     *     in this path.
     * @param  string  $path Directory path containing generator classes.
     * @return boolean Returns true on success, false otherwise.
     */
    public function addGeneratorPath($prefix, $path)
    {
        $path = realpath($path);
        $success = false;
        if ($path && !array_key_exists($prefix, $this->generatorPaths)) {
            $this->generatorPaths[$prefix] = $path;
            $success = true;
        }

        return $success;
    }

    /**
     * Clear all registered generator paths.
     *
     * @return self Returns an instance of self for method chaining.
     */
    public function clearGeneratorPaths()
    {
        $this->generatorPaths = array ();

        return $this;
    }

    /**
     * Get all registered generator paths.
     *
     * @return array An associative array of registered paths, using the prefix
     *     as a key.
     */
    public function getGeneratorPaths()
    {
        return $this->generatorPaths;
    }

    /**
     * Remove a registered generator path.
     *
     * @param  type $prefixOrPath The prefix or directory path to remove.
     * @return self Returns an instance of self for method chaining.
     */
    public function removeGeneratorPath($prefixOrPath)
    {
        if (array_key_exists($prefixOrPath, $this->generatorPaths)) {
            $prefix = $prefixOrPath;
            unset($this->generatorPaths[$prefix]);
        } elseif (($prefixOrPath = realpath($prefixOrPath)) && in_array($prefixOrPath, $this->generatorPaths)) {
            $path = $prefixOrPath;
            $generatorPaths = $this->generatorPaths;
            $this->generatorPaths = array_filter($generatorPaths, function ($value) use ($path) {
                return ($value != $path);
            });
        }

        return $this;
    }

    /**
     * Get a supported random data generator.
     *
     * Checks the available supported generators and attempts to return the best
     * possible generator.
     *
     * @return \Rych\Random\Generator\GeneratorInterface
     * @uses \Rych\Random\Generator\GeneratorInterface::getPriority() Used to
     *     sort the available generators from lowest to highest priority.
     */
    public function getGenerator()
    {
        if (!$this->generators) {
            $this->loadGenerators();
        }

        $generators = $this->generators;
        usort($generators, function ($a, $b) {
            return ($b::getPriority() - $a::getPriority());
        });

        $generator = null;
        if (isset ($generators[0])) {
            $class = $generators[0];
            $generator = new $class;
        }

        return $generator;
    }

    /**
     * Populate the available generators array.
     *
     * @return void
     * @uses \Rych\Random\Generator\GeneratorInterface Used to determine if a
     *     generator is supported by the system.
     */
    public function loadGenerators()
    {
        // Reset the list of loaded classes
        $this->generators = array ();

        // Loop through each registered path
        foreach ($this->generatorPaths as $generatorPrefix => $generatorPath) {
            // Build the iterators to search the path
            $dirIterator = new \RecursiveDirectoryIterator($generatorPath);
            $iteratorIterator = new \RecursiveIteratorIterator($dirIterator);
            $generatorIterator = new \RegexIterator($iteratorIterator, '/^.+\.php$/i');

            // Loop through the iterator looking for GeneratorInterface
            // instances
            foreach ($generatorIterator as $generatorFile) {
                // Determine additional namespace from file path
                $pathName = $generatorFile->getPath();
                if (substr($pathName, 0, strlen($generatorPath)) == $generatorPath) {
                    $pathName = substr($pathName, strlen($generatorPath), strlen($pathName));
                }

                // Best guess for class name is Prefix\Path\File
                $class = $generatorPrefix . '\\' . $pathName . $generatorFile->getBasename('.php');
                $class = str_replace('/', '\\', $class);

                // If the class doesn't exists and isn't autoloaded, try to
                // load it from the discovered file.
                if (!class_exists($class, true) && !in_array($generatorFile->getPathName(), get_included_files())) {
                    include $generatorFile->getPathname();
                }

                // If the class exists and implements GeneratorInterface,
                // append it to our list.
                if (class_exists($class, false) && in_array(__NAMESPACE__ . '\\GeneratorInterface', class_implements($class))) {
                    if ($class::isSupported()) {
                        $this->generators[] = $class;
                    }
                }
            }
        }
    }

}
