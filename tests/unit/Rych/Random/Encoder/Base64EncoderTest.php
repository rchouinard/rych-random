<?php

namespace Rych\Random\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

class Base64EncoderTest extends TestCase
{

    public function testEncodeMethodPrducesExpectedResult()
    {
        $encoder = new Base64Encoder;
        $this->assertEquals('', $encoder->encode(''));
        $this->assertEquals('QQ==', $encoder->encode('A'));
        $this->assertEquals('QUI=', $encoder->encode('AB'));
        $this->assertEquals('QUJD', $encoder->encode('ABC'));
        $this->assertEquals('QUJDRA==', $encoder->encode('ABCD'));
    }

    public function testDecodeMethodProducesExpectedResult()
    {
        $encoder = new Base64Encoder;
        $this->assertEquals('', $encoder->decode(''));
        $this->assertEquals('A', $encoder->decode('QQ=='));
        $this->assertEquals('AB', $encoder->decode('QUI='));
        $this->assertEquals('ABC', $encoder->decode('QUJD'));
        $this->assertEquals('ABCD', $encoder->decode('QUJDRA=='));
    }

}
