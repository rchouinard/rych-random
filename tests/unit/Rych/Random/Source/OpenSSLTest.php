<?php

namespace Rych\Random\Source;

use Rych\Random\Source\OpenSSL;

class OpenSSLTest extends \PHPUnit_Framework_TestCase
{

    private $source;

    public function setUp()
    {
        if (!extension_loaded('openssl')) {
            $this->markTestSkipped('Required extension openssl not loaded');
            return;
        }

        $this->source = new OpenSSL;
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
