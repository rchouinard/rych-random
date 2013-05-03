<?php

namespace Rych\Random\Tests;

use Rych\Random\Random;
use PHPUnit_Framework_TestCase as TestCase;

class RandomTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function testConstructorTakesGeneratorAndEncoder()
    {
        $generator = new \Rych\Random\Generator\MockGenerator;
        $encoder = new \Rych\Random\Encoder\Base32Encoder;

        $random = new Random($generator, $encoder);
        $this->assertInstanceOf('\\Rych\\Random\\Generator\\MockGenerator', $random->getGenerator());
        $this->assertInstanceOf('\\Rych\\Random\\Encoder\\Base32Encoder', $random->getEncoder());
    }

    /**
     * @test
     * @return void
     */
    public function testGenerateMethodsUsePassedInGenerator()
    {
        $generator = new \Rych\Random\Generator\MockGenerator;
        $generator->setMockString('0123456789');

        $random = new Random($generator);
        $this->assertEquals('01234567', $random->getRandomBytes(8));
        $this->assertEquals('wxyz0123', $random->getRandomString(8));
        $this->assertEquals(48, $random->getRandomInteger(0, 100));
    }

    /**
     * @test
     * @return void
     */
    public function testGenerateRandomBytesUsePassedInEncoder()
    {
        $generator = new \Rych\Random\Generator\MockGenerator;
        $generator->setMockString('0123456789');

        $encoder = new \Rych\Random\Encoder\HexEncoder;

        $random = new Random($generator, $encoder);
        $this->assertEquals('3031323334353637', $random->getRandomBytes(8));
    }

}
