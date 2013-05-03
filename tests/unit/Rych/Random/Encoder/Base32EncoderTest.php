<?php

namespace Rych\Random\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

class Base32EncoderTest extends TestCase
{

    /**
     * @var \Rych\Random\Encoder\EncoderInterface
     */
    protected $encoder;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->encoder = new Base32Encoder;
    }

    /**
     * @return array
     */
    public function vectorProvider()
    {
        return array (
            // Encoded, Decoded
            array ('', ''),
            array ('MY======', 'f'),
            array ('MZXQ====', 'fo'),
            array ('MZXW6===', 'foo'),
            array ('MZXW6YQ=', 'foob'),
            array ('MZXW6YTB', 'fooba'),
            array ('MZXW6YTBOI======', 'foobar'),
        );
    }

    /**
     * @dataProvider vectorProvider()
     * @test
     * @param string $encoded
     * @param string $decoded
     * @return void
     */
    public function testEncodeMethodPrducesExpectedResult($encoded, $decoded)
    {
        $this->assertEquals($encoded, $this->encoder->encode($decoded));
    }

    /**
     * @dataProvider vectorProvider()
     * @test
     * @param string $encoded
     * @param string $decoded
     * @return void
     */
    public function testDecodeMethodProducesExpectedResult($encoded, $decoded)
    {
        $this->assertEquals($decoded, $this->encoder->decode($encoded));
    }

}
