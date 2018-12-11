<?php

namespace Hotrush\Helper;

use \Hotrush\Exception\Timer\NotStartedException;
use \Hotrush\Exception\Timer\NotStoppedException;

/**
 * Timer for Duration tracing
 */
class Timer
{

    /**
     * Starting Timestamp
     *
     * @var double
     */
    private $startedOn = null;

    /**
     * Ending Timestamp
     *
     * @var double
     */
    private $stoppedOn = null;

    /**
     * Start the Timer
     *
     * @return void
     */
    public function start()
    {
        $this->startedOn = microtime(true);
    }

    /**
     * Stop the Timer
     *
     * @throws \Hotrush\Exception\Timer\NotStartedException
     * @return void
     */
    public function stop()
    {
        if ($this->startedOn === null) {
            throw new NotStartedException();
        }

        $this->stoppedOn = microtime(true);
    }

    /**
     * Get start time
     *
     * @return float
     * @throws NotStoppedException
     */
    public function getStartedOn(): float
    {
        if ($this->stoppedOn === null) {
            throw new NotStoppedException();
        }

        return $this->startedOn;
    }

    /**
     * Get the elapsed Duration of this Timer
     *
     * @throws \Hotrush\Exception\Timer\NotStoppedException
     * @return float
     */
    public function getDuration(): float
    {
        if ($this->stoppedOn === null) {
            throw new NotStoppedException();
        }

        return $this->toMilli($this->stoppedOn - $this->startedOn);
    }

    /**
     * Get the current elapsed Interval of the Timer
     *
     * @throws \Hotrush\Exception\Timer\NotStartedException
     * @return float
     */
    public function getElapsed(): float
    {
        if ($this->startedOn === null) {
            throw new NotStartedException();
        }

        return ($this->stoppedOn === null)
            ? $this->toMilli(microtime(true) - $this->startedOn)
            : $this->getDuration();
    }

    /**
     * Convert the Duration from Seconds to Milli-Seconds
     *
     * @param float $num
     * @return float
     */
    private function toMilli(float $num): float
    {
        return $num * 1000;
    }
}
