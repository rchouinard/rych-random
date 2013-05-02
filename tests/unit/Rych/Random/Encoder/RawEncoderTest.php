<?php

namespace Rych\Random\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

class RawEncoderTest extends TestCase
{

    public function testEncodeMethodPrducesExpectedResult()
    {
        $encoder = new RawEncoder;
        $this->assertEquals('', $encoder->encode(''));
        $this->assertEquals('A', $encoder->encode('A'));
        $this->assertEquals('AB', $encoder->encode('AB'));
        $this->assertEquals('ABC', $encoder->encode('ABC'));
        $this->assertEquals('ABCD', $encoder->encode('ABCD'));
    }

    public function testDecodeMethodProducesExpectedResult()
    {
        $encoder = new RawEncoder;
        $this->assertEquals('', $encoder->decode(''));
        $this->assertEquals('A', $encoder->decode('A'));
        $this->assertEquals('AB', $encoder->decode('AB'));
        $this->assertEquals('ABC', $encoder->decode('ABC'));
        $this->assertEquals('ABCD', $encoder->decode('ABCD'));
    }

}
