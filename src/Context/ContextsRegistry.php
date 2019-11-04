<?php

namespace Hotrush\Context;

use Hotrush\Context\Entities\Request;
use Hotrush\Context\Entities\User;
use Hotrush\Context\Entities\Tags;
use Hotrush\Context\Entities\Custom;

class ContextsRegistry
{
    /**
     * @var Request
     */
    private $request;

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
     * ContextsRegistry constructor.
     * @param Request|null $request
     * @param User|null $user
     * @param Tags|null $tags
     * @param Custom|null $custom
     */
    public function __construct(Request $request = null, User $user = null, Tags $tags = null, Custom $custom = null)
    {
        $this->request = $request ?: new Request();
        $this->user = $user ?: new User();
        $this->tags = $tags ?: new Tags();
        $this->custom = $custom ?: new Custom();
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
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return array|null
     */
    public function toArray()
    {
        $contexts = [];

        if (!$this->request->isEmpty()) {
            $contexts['request'] = $this->request->toArray();
        }

        if (!$this->user->isEmpty()) {
            $contexts['user'] = $this->user->toArray();
        }

        if (!$this->tags->isEmpty()) {
            $contexts['tags'] = $this->tags->toArray();
        }

        if (!$this->custom->isEmpty()) {
            $contexts['custom'] = $this->custom->toArray();
        }

        return $contexts ?: null;
    }
}