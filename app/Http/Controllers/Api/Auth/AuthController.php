<?php


namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api\Auth
 */
class AuthController extends Controller
{
    /**
     * @var
     */
    private $service;

    /**
     * AuthController constructor.
     * @param UsersService $service
     */
    public function __construct(UsersService $service)
    {
        $this->service = $service;
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        return response($this->service->register($request->all()), Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function confirmRegister(Request $request)
    {
        $authToken = $this->service->confirmRegister($request->token);
        if ($authToken) {
            return response(['token' => $authToken], Response::HTTP_OK);
        }
        return response('Invalid token', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function login(LoginRequest $request)
    {
        $token = $this->service->login($request->only(['email', 'password']));

        if ($token) {
            return response($token,
                Response::HTTP_CREATED);
        }

        return response('User not found', Response::HTTP_NOT_FOUND);

    }

}
