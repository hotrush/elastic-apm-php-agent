<?php

namespace Hotrush\Events;

use Hotrush\Context\ContextsRegistry;
use \Hotrush\Helper\Timer;

/**
 *
 * Abstract Transaction class for all inheriting Transactions
 *
 * @link https://www.elastic.co/guide/en/apm/server/master/transaction-api.html
 *
 */
class Transaction extends EventBean implements \JsonSerializable
{

    /**
     * Transaction Name
     *
     * @var string
     */
    private $name;

    /**
     * Transaction Timer
     *
     * @var \Hotrush\Helper\Timer
     */
    private $timer;

    /**
     * Transaction duration
     *
     * @var float
     */
    private $duration = 0.0;

    /**
     * @var array
     */
    private $spans = [];

    /**
     * Create the Transaction
     *
     * @param string            $name
     * @param ContextsRegistry  $contextsRegistry
     */
    public function __construct(string $name, ContextsRegistry $contextsRegistry = null)
    {
        parent::__construct($contextsRegistry);
        $this->setTransactionName($name);
        $this->timer = new Timer();
    }

    /**
     * Start the Transaction
     *
     * @return void
     */
    public function start()
    {
        $this->timer->start();
    }

    /**
     * Stop the Transaction
     *
     * @return void
     */
    public function stop()
    {
        // Stop the Timer
        $this->timer->stop();

        $this->duration = round($this->timer->getDuration(), 3);
    }

    /**
     * Set the Transaction Name
     *
     * @param string $name
     *
     * @return void
     */
    public function setTransactionName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the Transaction Name
     *
     * @return string
     */
    public function getTransactionName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @param array $spans
     */
    public function setSpans(array $spans)
    {
        $this->spans = $spans;
    }

    /**
     * @return array
     */
    public function getSpans(): array
    {
        return $this->spans;
    }

    /**
     * @return float
     * @throws \Hotrush\Exception\Timer\NotStoppedException
     */
    public function getTimerStartTime(): float
    {
        return $this->timer->getStartedOn();
    }

    /**
     * Serialize Transaction Event
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'timestamp' => $this->getTimestamp(),
            'name' => $this->getTransactionName(),
            'duration' => $this->getDuration(),
            'type' => $this->getMetaType(),
            'result' => $this->getMetaResult(),
            'context' => $this->getContext(),
            'spans' => $this->getSpans(),
        ];
    }

}
