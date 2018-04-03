<?php

namespace PhilKra\Events\Context;

class Contexts
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Tags
     */
    private $tags;

    /**
     * @var Custom
     */
    private $custom;

    /**
     * Contexts constructor.
     */
    public function __construct()
    {
        $this->user = new User();
        $this->tags = new Tags();
        $this->custom = new Custom();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Tags
     */
    public function getTags(): Tags
    {
        return $this->tags;
    }

    /**
     * @return Custom
     */
    public function getCustom(): Custom
    {
        return $this->custom;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $contexts = [];

        if (!$this->user->isEmpty()) {
            $contexts['user'] = $this->user->toArray();
        }

        if (!$this->tags->isEmpty()) {
            $contexts['tags'] = $this->tags->toArray();
        }

        if (!$this->custom->isEmpty()) {
            $contexts['custom'] = $this->custom->toArray();
        }

        return $contexts;
    }
}