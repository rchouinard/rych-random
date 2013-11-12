<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Tests\Encoder;

use Rych\Random\Encoder\Base64Encoder;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Base64 encoder tests
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
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
     * @test
     * @dataProvider vectorProvider()
     * @param  string $encoded
     * @param  string $decoded
     * @return void
     */
    public function testEncodeMethodPrducesExpectedResult($encoded, $decoded)
    {
        $this->assertEquals($encoded, $this->encoder->encode($decoded));
    }

    /**
     * @test
     * @dataProvider vectorProvider()
     * @param  string $encoded
     * @param  string $decoded
     * @return void
     */
    public function testDecodeMethodProducesExpectedResult($encoded, $decoded)
    {
        $this->assertEquals($decoded, $this->encoder->decode($encoded));
    }

}

