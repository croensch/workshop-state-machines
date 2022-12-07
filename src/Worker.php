<?php

declare(strict_types=1);

namespace App;

use App\Service\Database;
use App\Service\MailerService;

class Worker
{
    private $db;
    private $mailer;

    public function __construct(Database $em, MailerService $mailer)
    {
        $this->db = $em;
        $this->mailer = $mailer;
    }

    public function run()
    {
        $users = $this->db->getAllUsers();

        foreach ($users as $user) {
            // TODO Create a new StateMachine() object and call ->start()
            $sm = new \App\StateMachine\StateMachine($this->mailer, $user);
            $sm->start(new \App\StateMachine\State\AddYourName());
            // No DI required, just create a new object.
        }

        $this->db->saveUsers($users);
    }
}
