<?php

declare(strict_types=1);

namespace App\StateMachine;

use App\Entity\User;
use App\Service\MailerService;
use App\StateMachine\State\StateInterface;

class StateMachine implements StateMachineInterface
{
    private $user;
    private $state;
    private $mailer;

    public function __construct(MailerService $mailer, User $user)
    {
        $this->user = $user;
        $this->mailer = $mailer;
    }

    public function start(StateInterface $state): bool
    {
        // TODO Implement me
        $this->setState($state);
        // Run states until StateInterface::STOP
        do {
            $signal = $this->state->send($this, $this->mailer);
        } while ($signal !== StateInterface::STOP);
        return true;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setState(StateInterface $state): void
    {
        $this->state = $state;
    }
}
