<?php

namespace Rych\Random\Tests\Generator;

use Rych\Random\Generator\OpenSSLGenerator;
use PHPUnit_Framework_TestCase as TestCase;

class OpenSSLGeneratorTest extends TestCase
{

    protected function setUp()
    {
        if (!OpenSSLGenerator::isSupported()) {
            $this->markTestSkipped('OpenSSL is not supported on this platform.');
        }
    }

    public function testGenerateMethodProducesVaryingResultsEachCall()
    {
        $generator = new OpenSSLGenerator;
        $previous = array ();
        for ($i = 0; $i < 10; ++$i) {
            $result = $generator->generate(8);
            $this->assertTrue(strlen($result) === 8, 'Generator should produce a string length of eight.');
            $this->assertFalse(in_array($result, $previous), 'Generator should not duplicate a previous result in subsequent calls.');
            $previous[] = $result;
        }
    }

}
