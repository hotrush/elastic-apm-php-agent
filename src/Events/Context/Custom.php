<?php

namespace PhilKra\Events\Context;

class Custom implements ContextInterface
{
    /**
     * @var array
     */
    private $custom = [];

    /**
     * @param $key
     * @param $value
     */
    public function addCustom($key, $value)
    {
        $this->custom[$key] = $value;
    }

    /**
     * @param array $custom
     */
    public function setCustom(array $custom)
    {
        $this->custom = $custom;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->custom);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->custom;
    }
}