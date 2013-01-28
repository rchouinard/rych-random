<?php

namespace Rych\Random;

use PHPUnit_Framework_TestCase as TestCase;

class GeneratorTest extends TestCase
{

    /**
     * Test that Generator::getSource() returns a valid SourceInterface.
     *
     * @test
     */
    public function generatorReturnsAValidSource()
    {
        $generator = new Generator;
        $this->assertInstanceOf('Rych\\Random\\SourceInterface', $generator->getSource(), 'Generator::getSource() failed to return a valid instance of SourceInterface');
    }

    /**
     * Test that Generator::setSource() accepts and sets a SourceInterface.
     *
     * @test
     */
    public function generatorAcceptsAValidSource()
    {
        $mockSource = new Source\Mock;

        $generator = new Generator($mockSource);
        $this->assertInstanceOf('Rych\\Random\\Source\\Mock', $generator->getSource(), 'Generator::getSource() failed to return expected Mock source object');
        $this->assertEquals(16, strlen($generator->generate(16)), 'Generator::generate() failed to return the requested number of bytes');
    }
}
