<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserRequest;
use App\Http\Requests\API\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Services\API\UserService;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $data = $this->userService->create($request->validated());
        return $this->sendResponse(new UserResource($data), 201);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $token = $this->userService->login($request->validated());
        return $this->sendResponse($token, 200);
    }
}
