<?php

namespace Rych\Random\Encoder;

use PHPUnit_Framework_TestCase as TestCase;

class RawEncoderTest extends TestCase
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
        $this->encoder = new RawEncoder;
    }

    /**
     * @return array
     */
    public function vectorProvider()
    {
        return array (
            // Encoded, Decoded
            array ('', ''),
            array ('f', 'f'),
            array ('fo', 'fo'),
            array ('foo', 'foo'),
            array ('foob', 'foob'),
            array ('fooba', 'fooba'),
            array ('foobar', 'foobar'),
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
