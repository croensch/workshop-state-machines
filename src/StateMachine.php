<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class StateMachine
{
    private StateAwareInterface $stateAware;

    public function __construct($transitions = [], $stateAware = null)
    {
        if ($stateAware) {
            $this->stateAware = $stateAware;
        }
    }

    public function fromStateAware($stateAware, $transitions = []): static
    {
        return new static($transitions, $stateAware);
    }

    /**
     * Check if we are allowed to apply $state right now. Ie, is there an transition
     * from $this->state to $state?
     */
    public function can(StateAwareInterface $stateAware, string $transition): bool
    {
        $this->stateAware = $stateAware;
        // TODO write me
        switch ($transition) {
            case 'to_red':
                return $this->stateAware->getState() === 'yellow';
            case 'to_yellow':
                return $this->stateAware->getState() === 'green' || $this->stateAware->getState() === 'red';
            case 'to_green':
                return $this->stateAware->getState() === 'yellow'; // red?
            default:
                return false;
        }
    }

    /**
     * This will update $this->state.
     *
     * @throws \InvalidArgumentException if the $newState is invalid.
     */
    public function apply(StateAwareInterface $stateAware, string $transition): void
    {
        // TODO write me
        if (!$this->can($stateAware, $transition)) {
            throw new InvalidArgumentException('New state is invalid');
        }

        switch ($transition) {
            case 'to_red':
                $this->stateAware->setState('red');
                break;
            case 'to_yellow':
                $this->stateAware->setState('yellow');
                break;
            case 'to_green':
                $this->stateAware->setState('green');
                break;
            default:
                break;
        }
    }
}
