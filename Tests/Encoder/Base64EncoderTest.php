<?php

namespace Rych\Random\Tests\Encoder;

use Rych\Random\Encoder\Base64Encoder;
use PHPUnit_Framework_TestCase as TestCase;

class Base64EncoderTest extends TestCase
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
        $this->encoder = new Base64Encoder;
    }

    /**
     * @return array
     */
    public function vectorProvider()
    {
        return array (
            // Encoded, Decoded
            array ('', ''),
            array ('Zg==', 'f'),
            array ('Zm8=', 'fo'),
            array ('Zm9v', 'foo'),
            array ('Zm9vYg==', 'foob'),
            array ('Zm9vYmE=', 'fooba'),
            array ('Zm9vYmFy', 'foobar'),
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
