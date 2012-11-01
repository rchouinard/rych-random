<?php

namespace Rych\Random\Source;

use Rych\Random\Source\MTRand;

class MTRandTest extends \PHPUnit_Framework_TestCase
{

    private $source;

    public function setUp()
    {
        $this->source = new MTRand;
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
