<?php

namespace Hotrush\Serializers;

use \Hotrush\Helper\Config;
use \Hotrush\Stores\TransactionsStore;

/**
 *
 * Convert the Registered Transactions to JSON Schema
 *
 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
 *
 */
class Transactions extends Entity implements \JsonSerializable
{

    /**
     * @var \Hotrush\Stores\TransactionsStore
     */
    private $store;

    /**
     * @param Config            $config
     * @param TransactionsStore $store
     */
    public function __construct(Config $config, TransactionsStore $store)
    {
        parent::__construct($config);
        $this->store = $store;
    }

    /**
     * Serialize Transactions Data to JSON "ready" Array
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->getSkeleton() + [
                'transactions' => $this->store
            ];
    }

}
