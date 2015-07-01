<?php
/**
 * Ryan's Random Data Library
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

namespace Rych\Random\Tests\Generator;

use Rych\Random\Generator\MCryptGenerator;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Mcrypt generator tests
 *
 * @package Rych\Random
 * @author Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2013, Ryan Chouinard
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class MCryptGeneratorTest extends TestCase
{

    /**
     * @return void
     */
    protected function setUp()
    {
        if (!MCryptGenerator::isSupported()) {
            $this->markTestSkipped('mcrypt is not supported on this platform.');
        }
    }

    /**
     * @test
     * @return void
     */
    public function testGenerateMethodProducesVaryingResultsEachCall()
    {
        $generator = new MCryptGenerator;
        $previous = array ();
        for ($i = 0; $i < 10; ++$i) {
            $result = $generator->generate(8);
            $this->assertTrue(strlen($result) === 8, 'Generator should produce a string length of eight.');
            $this->assertFalse(in_array($result, $previous), 'Generator should not duplicate a previous result in subsequent calls.');
            $previous[] = $result;
        }
    }

    /**
     * @test
     * @return void
     */
    public function testGetPriorityMethodReturnsInteger()
    {
        $this->assertInternalType('integer', MCryptGenerator::getPriority(), 'Generator should express priority as an integer value.');
        $this->assertTrue(0 < MCryptGenerator::getPriority() && 4 > MCryptGenerator::getPriority(), 'Generator should have a priority between 1 and 3.');
    }

}

