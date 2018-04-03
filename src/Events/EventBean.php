<?php

namespace Hotrush\Events;

use \Ramsey\Uuid\Uuid;
use Hotrush\Context\ContextsRegistry;

/**
 *
 * EventBean for occuring events such as Excpetions or Transactions
 *
 */
class EventBean
{
    /**
     * UUID
     *
     * @var string
     */
    private $id;

    /**
     * Error occurred on Timestamp
     *
     * @var string
     */
    private $timestamp;

    /**
     * Event Metadata
     *
     * @var array
     */
    private $meta = [
        'result' => 200,
        'type' => 'generic'
    ];

    /**
     * @var ContextsRegistry
     */
    private $contextsRegistry;

    /**
     * Init the Event with the Timestamp and UUID
     *
     * @link https://github.com/Hotrush/elastic-apm-php-agent/issues/3
     *
     * @param ContextsRegistry $contextsRegistry
     */
    public function __construct(ContextsRegistry $contextsRegistry = null)
    {
        // Generate Random UUID
        $this->id = Uuid::uuid4()->toString();

        $this->contextsRegistry = $contextsRegistry ?: new ContextsRegistry();

        // Get UTC timestamp of Now
        $timestamp = \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)));
        $timestamp->setTimeZone(new \DateTimeZone('UTC'));
        $this->timestamp = $timestamp->format('Y-m-d\TH:i:s.u\Z');
    }

    /**
     * Get the Event Id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the Event's Timestamp
     *
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * Set the Transaction Meta data
     *
     * @param array $meta
     *
     * @return void
     */
    public final function setMeta(array $meta)
    {
        $this->meta = array_merge($this->meta, $meta);
    }

    /**
     * Get Type defined in Meta
     *
     * @return string
     */
    protected final function getMetaType(): string
    {
        return $this->meta['type'];
    }

    /**
     * Get the Result of the Event from the Meta store
     *
     * @return string
     */
    protected final function getMetaResult(): string
    {
        return (string)$this->meta['result'];
    }

    /**
     * @return ContextsRegistry
     */
    public function getContextsRegistry(): ContextsRegistry
    {
        return $this->contextsRegistry;
    }

    /**
     * Get the Events Context
     *
     * @link https://www.elastic.co/guide/en/apm/server/current/transaction-api.html#transaction-context-schema
     *
     * @return array
     */
    protected final function getContext(): array
    {
        return $this->contextsRegistry->toArray();
    }

}
