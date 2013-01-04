<?php

namespace Rych\Random\Source;

use Rych\Random\Source\CAPICOM;

class CAPICOMTest extends \PHPUnit_Framework_TestCase
{

    private $source;

    public function setUp()
    {
        if (!extension_loaded('com_dotnet')) {
            $this->markTestSkipped('Required extension com_dotnet not loaded');
            return;
        }

        $this->source = new CAPICOM;
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
