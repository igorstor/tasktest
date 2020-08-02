<?php

namespace App\Listeners;

use App\Events\ConfirmRegister;
use App\Notifications\ConfirmRegistration;

/**
 * Class ConfirmRegisterListener
 * @package App\Listeners
 */
class ConfirmRegisterListener
{
    /**
     * @param ConfirmRegister $event
     */
    public function handle(ConfirmRegister $event)
    {
        $user = $event->getUser();
        if ($user->email) {
            $user->notify(new ConfirmRegistration($event->getToken()));
        }
    }
}
