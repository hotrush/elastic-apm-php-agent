<?php

namespace PhilKra\Serializers;

use \PhilKra\Helper\Config;
use \PhilKra\Stores\ErrorsStore;

/**
 *
 * Convert the Registered Errors to JSON Schema
 *
 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
 *
 */
class Errors extends Entity implements \JsonSerializable
{

    /**
     * @var \PhilKra\Stores\ErrorsStore
     */
    private $store;

    /**
     * @param Config        $config
     * @param ErrorsStore   $store
     */
    public function __construct(Config $config, ErrorsStore $store)
    {
        parent::__construct($config);
        $this->store = $store;
    }

    /**
     * Serialize Error Data to JSON "ready" Array
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->getSkeleton() + [
                'errors' => $this->store
            ];
    }

}
