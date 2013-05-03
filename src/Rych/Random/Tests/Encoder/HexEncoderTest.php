<?php

namespace Rych\Random\Tests\Encoder;

use Rych\Random\Encoder\HexEncoder;
use PHPUnit_Framework_TestCase as TestCase;

class HexEncoderTest extends TestCase
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
        $this->encoder = new HexEncoder;
    }

    /**
     * @return array
     */
    public function vectorProvider()
    {
        return array (
            // Encoded, Decoded
            array ('', ''),
            array ('66', 'f'),
            array ('666f', 'fo'),
            array ('666f6f', 'foo'),
            array ('666f6f62', 'foob'),
            array ('666f6f6261', 'fooba'),
            array ('666f6f626172', 'foobar'),
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
