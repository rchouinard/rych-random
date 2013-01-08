<?php

namespace Rych\Random\Source;

use Rych\Random\Source\Native;

class NativeTest extends \PHPUnit_Framework_TestCase
{

    private $source;

    public function setUp()
    {
        $this->source = new Native;
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
