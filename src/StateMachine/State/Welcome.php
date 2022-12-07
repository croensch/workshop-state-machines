<?php

declare(strict_types=1);

namespace App\StateMachine\State;

use App\Service\MailerService;
use App\StateMachine\StateMachineInterface;
use App\WorldClock;

class Welcome implements StateInterface
{
    public function send(StateMachineInterface $stateMachine, MailerService $mailer): int
    {
        $user = $stateMachine->getUser();

        if ($user->getNotifiedAt() !== null && $user->getNotifiedAt() < WorldClock::getDateTimeRelativeFakeTime('+1 day')->getTimestamp()) {
            $stateMachine->setState(new Wait());
            return StateInterface::CONTINUE;
        }

        $mailer->sendEmail($user, sprintf('Welcome %s', $user->getName()));
        $user->setNotifiedAt(WorldClock::getCurrentTimestamp());
        $stateMachine->setState(new Done());
        return StateInterface::CONTINUE;
    }
}
