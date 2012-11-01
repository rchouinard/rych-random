<?php

namespace Rych\Random\Source;

use Rych\Random\Source\URandom;

class URandomTest extends \PHPUnit_Framework_TestCase
{

    private $source;

    public function setUp()
    {
        if (!is_readable('/dev/urandom')) {
            $this->markTestSkipped('Cannot read from /dev/urandom');
            return;
        }

        $this->source = new URandom;
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
