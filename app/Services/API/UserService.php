<?php

namespace App\Services\API;

use App\Exceptions\InvalidCredentialsException;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserService
{
    private VoucherCodeService $voucherCodeService;
    public function __construct(VoucherCodeService $voucherCodeService)
    {
        $this->voucherCodeService = $voucherCodeService;
    }

    public function create(array $params): User
    {
        $user = User::create($params);

        auth()->login($user);

        $voucherCode = $this->voucherCodeService->create();

        Mail::to($user->email)->send(new WelcomeEmail($voucherCode, $user));

        return $user;
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function login(array $params): array
    {
        if (auth()->attempt(request()->only('email', 'password'))) {
            $user = auth()->user();
            $token = $user->createToken('user-token')->plainTextToken;

            return ['token' => $token];
        }

        throw new InvalidCredentialsException();
    }
}
