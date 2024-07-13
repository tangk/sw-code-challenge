<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserRequest;
use App\Http\Requests\API\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Services\API\UserService;
use Exception;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(CreateUserRequest $request)
    {
        $request->validated();

        try {
            $data = $this->userService->create($request->all());

            return $this->sendResponse(new UserResource($data), 201);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), $e->getCode());
        }
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated();

        try {
            $data = $this->userService->login($request->all());

            return $this->sendResponse($data, 200);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), $e->getCode());
        }
    }
}
