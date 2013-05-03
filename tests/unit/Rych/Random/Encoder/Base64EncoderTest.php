<?php

namespace Rych\Random\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

class Base64EncoderTest extends TestCase
{

    public function testEncodeMethodPrducesExpectedResult()
    {
        $encoder = new Base64Encoder;

        // RFC 4648 test vectors
        $this->assertEquals('', $encoder->encode(''));
        $this->assertEquals('Zg==', $encoder->encode('f'));
        $this->assertEquals('Zm8=', $encoder->encode('fo'));
        $this->assertEquals('Zm9v', $encoder->encode('foo'));
        $this->assertEquals('Zm9vYg==', $encoder->encode('foob'));
        $this->assertEquals('Zm9vYmE=', $encoder->encode('fooba'));
        $this->assertEquals('Zm9vYmFy', $encoder->encode('foobar'));
    }

    public function testDecodeMethodProducesExpectedResult()
    {
        $encoder = new Base64Encoder;

        // RFC 4648 test vectors
        $this->assertEquals('', $encoder->decode(''));
        $this->assertEquals('f', $encoder->decode('Zg=='));
        $this->assertEquals('fo', $encoder->decode('Zm8='));
        $this->assertEquals('foo', $encoder->decode('Zm9v'));
        $this->assertEquals('foob', $encoder->decode('Zm9vYg=='));
        $this->assertEquals('fooba', $encoder->decode('Zm9vYmE='));
        $this->assertEquals('foobar', $encoder->decode('Zm9vYmFy'));
    }

}
