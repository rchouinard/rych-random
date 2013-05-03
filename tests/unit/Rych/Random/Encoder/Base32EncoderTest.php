<?php

namespace Rych\Random\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

class Base32EncoderTest extends TestCase
{

    public function testEncodeMethodPrducesExpectedResult()
    {
        $encoder = new Base32Encoder;

        // RFC 4648 test vectors
        $this->assertEquals('', $encoder->encode(''));
        $this->assertEquals('MY======', $encoder->encode('f'));
        $this->assertEquals('MZXQ====', $encoder->encode('fo'));
        $this->assertEquals('MZXW6===', $encoder->encode('foo'));
        $this->assertEquals('MZXW6YQ=', $encoder->encode('foob'));
        $this->assertEquals('MZXW6YTB', $encoder->encode('fooba'));
        $this->assertEquals('MZXW6YTBOI======', $encoder->encode('foobar'));
    }

    public function testDecodeMethodProducesExpectedResult()
    {
        $encoder = new Base32Encoder;

        // RFC 4648 test vectors
        $this->assertEquals('', $encoder->decode(''));
        $this->assertEquals('f', $encoder->decode('MY======'));
        $this->assertEquals('fo', $encoder->decode('MZXQ===='));
        $this->assertEquals('foo', $encoder->decode('MZXW6==='));
        $this->assertEquals('foob', $encoder->decode('MZXW6YQ='));
        $this->assertEquals('fooba', $encoder->decode('MZXW6YTB'));
        $this->assertEquals('foobar', $encoder->decode('MZXW6YTBOI======'));
    }

}
