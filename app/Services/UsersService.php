<?php

namespace App\Services;

use App\Events\ConfirmRegister;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\VerifyUserRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UsersService
 * @package App\Services
 */
class UsersService
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private $authManager;
    /**
     * @var VerifyUserRepository
     */
    private $verifyRepository;

    /**
     * UsersService constructor.
     * @param UserRepository $userRepository
     * @param AuthManager $authManager
     * @param VerifyUserRepository $verifyRepository
     */
    public function __construct(
        UserRepository $userRepository,
        AuthManager $authManager,
        VerifyUserRepository $verifyRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->authManager = $authManager->guard();
        $this->verifyRepository = $verifyRepository;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Exception
     */
    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($data);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        if ($user) {
            $token = $this->generateToken($user->email);
            $request = [
                'user_id' => $user->id,
                'token' => $token,
            ];

            $this->verifyRepository->updateOrCreate(['user_id' => $user->id], $request);

            event(new ConfirmRegister($user, $token));

        }
        return $user;
    }

    /**
     * @param string $token
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function confirmRegister(string $token)
    {
        $confirmUser = $this->verifyRepository->checkToken($token);
        if ($confirmUser) {
            $confirmUser->user->update(['email_verified_at' => now()]);
            return JWTAuth::fromUser($confirmUser->user);
        }
    }

    /**
     * @param array $data
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function login(array $data)
    {
        $user = $this->userRepository->firstWhere(['email' => $data['email']]);
        if ($user && !is_null($user->email_verified_at)) {
            $token = $this->authManager->attempt($data, now()->addWeek(1));
            if ($token) {
                $data = [
                    'user' => $user,
                    'token' => JWTAuth::fromUser($user)
                ];
                return $data;
            }
        }
    }


    /**
     * @param string $email
     * @return string
     */
    public function generateToken(string $email)
    {
        return hash('tiger192,3', $email);
    }

    /**
     * Log out from system
     */
    public function logout()
    {
        $this->authManager->logout();
    }

}
