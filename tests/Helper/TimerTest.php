<?php

namespace Hotrush\Tests\Helper;

use \Hotrush\Helper\Timer;
use \PHPUnit\Framework\TestCase;

/**
 * Test Case for @see \Hotrush\Helper\Timer
 */
final class TimerTest extends TestCase
{

    /**
     * @covers \Hotrush\Helper\Timer::start
     * @covers \Hotrush\Helper\Timer::stop
     * @covers \Hotrush\Helper\Timer::getDuration
     * @covers \Hotrush\Helper\Timer::toMicro
     */
    public function testCanBeStartedAndStoppedWithDuration()
    {
        $timer = new Timer();
        $duration = rand(25, 100);

        $timer->start();
        usleep($duration);
        $timer->stop();

        $this->assertGreaterThanOrEqual($duration, $timer->getDuration());
    }

    /**
     * @depends testCanBeStartedAndStoppedWithDuration
     *
     * @covers  \Hotrush\Helper\Timer::start
     * @covers  \Hotrush\Helper\Timer::stop
     * @covers  \Hotrush\Helper\Timer::getDuration
     * @covers  \Hotrush\Helper\Timer::getElapsed
     * @covers  \Hotrush\Helper\Timer::toMicro
     */
    public function testGetElapsedDurationWithoutError()
    {
        $timer = new Timer();

        $timer->start();
        usleep(10);
        $elapsed = $timer->getElapsed();
        $timer->stop();

        $this->assertGreaterThanOrEqual($elapsed, $timer->getDuration());
        $this->assertEquals($timer->getElapsed(), $timer->getDuration());
    }

    /**
     * @depends testCanBeStartedAndStoppedWithDuration
     *
     * @expectedException \Hotrush\Exception\Timer\NotStoppedException
     *
     * @covers  \Hotrush\Helper\Timer::start
     * @covers  \Hotrush\Helper\Timer::getDuration
     */
    public function testCanBeStartedWithForcingDurationException()
    {
        $timer = new Timer();
        $timer->start();
        $timer->getDuration();
    }

    /**
     * @depends testCanBeStartedWithForcingDurationException
     *
     * @expectedException \Hotrush\Exception\Timer\NotStartedException
     *
     * @covers  \Hotrush\Helper\Timer::stop
     */
    public function testCannotBeStoppedWithoutStart()
    {
        $timer = new Timer();
        $timer->stop();
    }

}
