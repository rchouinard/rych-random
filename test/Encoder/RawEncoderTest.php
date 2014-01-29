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

use Rych\Random\Encoder\RawEncoder;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Raw encoder tests
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
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

