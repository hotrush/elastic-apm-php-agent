<?php

namespace PhilKra\Events\Context;

class User implements ContextInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @param $id
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param $username
     * @return self
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param $email
     * @return self
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->id || $this->username || $this->email;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $user = [];

        if ($this->id) {
            $user['id'] = $this->id;
        }

        if ($this->username) {
            $user['username'] = $this->username;
        }

        if ($this->email) {
            $user['email'] = $this->email;
        }

        return $user;
    }
}