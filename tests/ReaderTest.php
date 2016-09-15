<?php

namespace Choccybiccy\Mobi;

/**
 * Class ReaderTest.
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $mobi = new Reader(new \SplFileObject($this->getMobiPath()));
        $this->assertInstanceOf(Reader::class, $mobi);
    }

    /**
     * @return string
     */
    protected function getMobiPath()
    {
        return realpath(__DIR__ . '/../resources/The_Adventures_of_Sherlock_Holmes_by_Doyle.mobi');
    }

    /**
     * @param array|null $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|Reader
     */
    protected function getMockReader(array $methods = null)
    {
        return $this->getMockBuilder(Reader::class)
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }
}

