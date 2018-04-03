<?php

namespace PhilKra\Events\Context;

class Tags implements ContextInterface
{
    /**
     * @var array
     */
    private $tags = [];

    /**
     * @param $key
     * @param $value
     */
    public function addTag($key, $value)
    {
        $this->tags[$key] = (string) $value;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    public function isEmpty(): bool
    {
        return empty($this->tags);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->tags;
    }
}