<?php

namespace Hotrush\Context\Entities;

interface EntityInterface
{
    public function isEmpty(): bool;

    public function toArray(): array;
}