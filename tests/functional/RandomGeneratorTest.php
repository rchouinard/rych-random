<?php

use Rych\Random\Generator;
use Rych\Random\Source\MCrypt as MCryptSource;
use Rych\Random\Source\Native as NativeSource;
use Rych\Random\Source\OpenSSL as OpenSSLSource;
use Rych\Random\Exception;

class RandomGeneratorTest extends PHPUnit_Framework_TestCase
{

    private $generator;

    public function setUp()
    {
        $this->generator = new Generator;
    }

    public function testSetSourceMethodModifiesSourceProperty()
    {
        try {
            $ref = new ReflectionObject($this->generator);
            $refProp = $ref->getProperty('source');
            $refProp->setAccessible(true);

            $this->assertNull($refProp->getValue($this->generator));

            $this->generator->setSource(new OpenSSLSource);
            $this->assertInstanceOf(
                'Rych\Random\Source\OpenSSL',
                $refProp->getValue($this->generator)
            );

            $this->assertInstanceOf(
                'Rych\Random\Source\OpenSSL',
                $this->generator->getSource()
            );
        } catch (Exception $e) {
            $this->markTestSkipped($e->getMessage());
        }
    }

    public function testGetSourceMethodChoosesDefaultSource()
    {
        try {
            $this->assertInstanceOf(
                'Rych\Random\Source',
                $this->generator->getSource()
            );
        } catch (Exception $e) {
            $this->markTestSkipped($e->getMessage());
        }
    }

    public function testSetSourceMethodReplacesCurrentSource()
    {
        try {
            $this->generator->setSource(new MCryptSource);
            $this->assertInstanceOf(
                'Rych\Random\Source\MCrypt',
                $this->generator->getSource()
            );

            $this->generator->setSource(new NativeSource);
            $this->assertInstanceOf(
                'Rych\Random\Source\Native',
                $this->generator->getSource()
            );
        } catch (Exception $e) {
            $this->markTestSkipped($e->getMessage());
        }
    }

}
