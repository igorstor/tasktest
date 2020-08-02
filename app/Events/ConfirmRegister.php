<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class ConfirmRegister
 * @package App\Events
 */
class ConfirmRegister
{
    use SerializesModels;

    /**
     * @var
     */
    private $user;
    /**
     * @var
     */
    private $token;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $token = null)
    {
        $this->user = $user;
        $this->token = $token;
    }


    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
