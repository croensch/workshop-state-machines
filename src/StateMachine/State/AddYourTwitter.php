<?php

declare(strict_types=1);

namespace App\StateMachine\State;

use App\Service\MailerService;
use App\StateMachine\StateMachineInterface;
use App\WorldClock;

class AddYourTwitter implements StateInterface
{
    public function send(StateMachineInterface $stateMachine, MailerService $mailer): int
    {
        $user = $stateMachine->getUser();

        // TODO Do some conditional checks
        if ($user->getTwitter() !== null && $user->getTwitter() !== "") {
            $stateMachine->setState(new Welcome());
            return StateInterface::CONTINUE;
        }
        if ($user->getNotifiedAt() !== null && $user->getNotifiedAt() < WorldClock::getDateTimeRelativeFakeTime('+1 day')->getTimestamp()) {
            $stateMachine->setState(new Wait());
            return StateInterface::CONTINUE;
        }
        // Optional: send an email
        $mailer->sendEmail($user, sprintf('Hi %s! Add your Twitter, please.', $user->getName()));
        $user->setNotifiedAt(WorldClock::getCurrentTimestamp());
        // Optional: Move to a new state
        $stateMachine->setState(new Wait());
        return StateInterface::CONTINUE;
    }

}