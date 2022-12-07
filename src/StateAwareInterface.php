<?php

declare(strict_types=1);

namespace App;

interface StateAwareInterface
{
    public static function fromState(string $state): static;

    public function getState(): string;

    public function setState(string $state): void;
}
