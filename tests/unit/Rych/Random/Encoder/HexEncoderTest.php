<?php

namespace Rych\Random\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

class HexEncoderTest extends TestCase
{

    public function testEncodeMethodPrducesExpectedResult()
    {
        $encoder = new HexEncoder;
        $this->assertEquals('', $encoder->encode(''));
        $this->assertEquals('41', $encoder->encode('A'));
        $this->assertEquals('4142', $encoder->encode('AB'));
        $this->assertEquals('414243', $encoder->encode('ABC'));
        $this->assertEquals('41424344', $encoder->encode('ABCD'));
    }

    public function testDecodeMethodProducesExpectedResult()
    {
        $encoder = new HexEncoder;
        $this->assertEquals('', $encoder->decode(''));
        $this->assertEquals('A', $encoder->decode('41'));
        $this->assertEquals('AB', $encoder->decode('4142'));
        $this->assertEquals('ABC', $encoder->decode('414243'));
        $this->assertEquals('ABCD', $encoder->decode('41424344'));
    }

}
