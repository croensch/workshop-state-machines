<?php

declare(strict_types=1);

namespace App\Entity;

use App\StateAwareInterface;

class TrafficLight implements StateAwareInterface
{
    private string $state;

    public function __construct(string $state)
    {
        $this->state = $state;
    }

    public static function fromState(string $state): static
    {
        return new static($state);
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }
}
