<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class TrafficLightStateMachine
{
    /** @var string State. (Exercise 1) This variable name is used in tests. Do not rename.  */
    private $state;

    public function toStateAware($class): StateAwareInterface
    {
        assert(in_array(StateAwareInterface::class, class_implements($class) ?: []));
        return $class::fromState($this->state);
    }

    /**
     * Check if we are allowed to apply $state right now. Ie, is there an transition
     * from $this->state to $state?
     */
    public function can(string $transition): bool
    {
        // TODO write me
        switch ($transition) {
            case 'to_red':
                return $this->state === 'yellow';
            case 'to_yellow':
                return $this->state === 'green' || $this->state === 'red';
            case 'to_green':
                return $this->state === 'yellow'; // red?
            default:
                return false;
        }
    }

    /**
     * This will update $this->state.
     *
     * @throws \InvalidArgumentException if the $newState is invalid.
     */
    public function apply(string $transition): void
    {
        // TODO write me
        if (!$this->can($transition)) {
            throw new InvalidArgumentException('New state is invalid');
        }

        switch ($transition) {
            case 'to_red':
                $this->state = 'red';
                break;
            case 'to_yellow':
                $this->state = 'yellow';
                break;
            case 'to_green':
                $this->state = 'green';
                break;
            default:
                break;
        }
    }
}
