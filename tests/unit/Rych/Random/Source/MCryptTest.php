<?php

namespace Rych\Random\Source;

use Rych\Random\Source\MCrypt;

class MCryptTest extends \PHPUnit_Framework_TestCase
{

    private $source;

    public function setUp()
    {
        if (!extension_loaded('mcrypt')) {
            $this->markTestSkipped('Required extension mcrypt not loaded');
            return;
        }

        $this->source = new MCrypt;
    }

    public function testRead()
    {
        $first = $this->source->read(32);
        $this->assertTrue(strlen($first) == 32);

        $second = $this->source->read(32);
        $this->assertTrue(strlen($second) == 32);

        $this->assertTrue($first !== $second);
    }

}
