<?php

namespace Rych\Random\Tests\Generator;

use Rych\Random\Generator\MCryptGenerator;
use PHPUnit_Framework_TestCase as TestCase;

class MCryptGeneratorTest extends TestCase
{

    protected function setUp()
    {
        if (!MCryptGenerator::isSupported()) {
            $this->markTestSkipped('mcrypt is not supported on this platform.');
        }
    }

    public function testGenerateMethodProducesVaryingResultsEachCall()
    {
        $generator = new MCryptGenerator;
        $previous = array ();
        for ($i = 0; $i < 10; ++$i) {
            $result = $generator->generate(8);
            $this->assertTrue(strlen($result) === 8, 'Generator should produce a string length of eight.');
            $this->assertFalse(in_array($result, $previous), 'Generator should not duplicate a previous result in subsequent calls.');
            $previous[] = $result;
        }
    }

}
