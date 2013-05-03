<?php

namespace Rych\Random\Tests\Generator;

use Rych\Random\Generator\URandomGenerator;
use PHPUnit_Framework_TestCase as TestCase;

class URandomGeneratorTest extends TestCase
{

    protected function setUp()
    {
        if (!URandomGenerator::isSupported()) {
            $this->markTestSkipped('/dev/urandom is not supported on this platform.');
        }
    }

    public function testGenerateMethodProducesVaryingResultsEachCall()
    {
        $generator = new URandomGenerator;
        $previous = array ();
        for ($i = 0; $i < 10; ++$i) {
            $result = $generator->generate(8);
            $this->assertTrue(strlen($result) === 8, 'Generator should produce a string length of eight.');
            $this->assertFalse(in_array($result, $previous), 'Generator should not duplicate a previous result in subsequent calls.');
            $previous[] = $result;
        }
    }

}
