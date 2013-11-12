<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Tests\Generator;

use Rych\Random\Generator\GeneratorFactory;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Generator factory tests
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class GeneratorFactoryTest extends TestCase
{

    /**
     * @var \Rych\Random\Generator\GeneratorFactory
     */
    protected $factory;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->factory = new GeneratorFactory;
    }

    /**
     * @test
     * @return void
     */
    public function testFactoryHasDefaultGeneratorPath()
    {
        $generatorPrefix = 'Rych\\Random\\Generator';
        $generatorPath = realpath(__DIR__ . '/../../Generator/');

        $factoryPaths = $this->factory->getGeneratorPaths();
        $this->assertEquals(1, count($factoryPaths));
        $this->assertArrayHasKey($generatorPrefix, $factoryPaths);
        $this->assertEquals($generatorPath, $factoryPaths[$generatorPrefix]);
    }

    /**
     * @test
     * @return void
     */
    public function testFactoryAcceptsAdditionalPaths()
    {
        $newPrefix = 'My\\Custom\\Generator';
        $newPath = realpath(__DIR__ . '/../fixtures/Generator');

        $this->factory->addGeneratorPath($newPrefix, $newPath);

        $factoryPaths = $this->factory->getGeneratorPaths();
        $this->assertEquals(2, count($factoryPaths));
        $this->assertArrayHasKey($newPrefix, $factoryPaths);
        $this->assertEquals($newPath, $factoryPaths[$newPrefix]);
    }

    /**
     * @test
     * @return void
     */
    public function testFactoryCanRemovePathByPrefix()
    {
        $newPrefix = 'My\\Custom\\Generator';
        $newPath = realpath(__DIR__ . '/../fixtures/Generator');

        $this->factory->addGeneratorPath($newPrefix, $newPath);
        $this->factory->removeGeneratorPath('Rych\\Random\\Generator');

        $factoryPaths = $this->factory->getGeneratorPaths();
        $this->assertEquals(1, count($factoryPaths));
        $this->assertArrayHasKey($newPrefix, $factoryPaths);
        $this->assertEquals($newPath, $factoryPaths[$newPrefix]);
    }

    /**
     * @test
     * @return void
     */
    public function testFactoryCanRemovePathByPath()
    {
        $newPrefix = 'My\\Custom\\Generator';
        $newPath = realpath(__DIR__ . '/../fixtures/Generator');

        $this->factory->addGeneratorPath($newPrefix, $newPath);
        $this->factory->removeGeneratorPath(realpath(__DIR__ . '/../../Generator/'));

        $factoryPaths = $this->factory->getGeneratorPaths();
        $this->assertEquals(1, count($factoryPaths));
        $this->assertArrayHasKey($newPrefix, $factoryPaths);
        $this->assertEquals($newPath, $factoryPaths[$newPrefix]);
    }

    /**
     * @test
     * @return void
     */
    public function testFactoryClearsPathsWhenAsked()
    {
        $this->factory->clearGeneratorPaths();

        $factoryPaths = $this->factory->getGeneratorPaths();
        $this->assertEquals(0, count($factoryPaths));
    }

    /**
     * @test
     * @return void
     */
    public function testFactoryLoadsOtherGenerators()
    {
        $newPrefix = 'My\\Custom\\Generator';
        $newPath = realpath(__DIR__ . '/../fixtures/Generator');

        $this->factory->clearGeneratorPaths();
        $this->factory->addGeneratorPath($newPrefix, $newPath);
        $this->factory->loadGenerators();

        $this->assertInstanceOf($newPrefix . '\\TestGenerator', $this->factory->getGenerator());
    }

    /**
     * @test
     * @return void
     */
    public function testFactoryReturnsNullWithNoPaths()
    {
        $this->factory->clearGeneratorPaths();
        $this->factory->loadGenerators();

        $this->assertNull($this->factory->getGenerator());
    }

}

