<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserRequest;
use App\Models\User;
use App\Services\API\VoucherCodeService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class UserController extends Controller
{
    private VoucherCodeService $voucherCodeService;

    public function __construct(VoucherCodeService $voucherCodeService)
    {
        parent::__construct();
        $this->voucherCodeService = $voucherCodeService;
    }

    public function create(CreateUserRequest $request)
    {
        $request->validated();

        try {
            $user = User::create([
                'username' => $request->getUserName(),
                'first_name' => $request->getFirstName(),
                'email' => $request->getEmail(),
                'password' => Hash::make($request->getPassword()),
            ]);

            auth()->login($user);

            $voucherCode = $this->voucherCodeService->create();

            Mail::to($user->email)->send(new WelcomeEmail($voucherCode, $user));

            $this->response['data'] = $user->toArray();
        } catch (Exception $e) {
            $this->response = [ 'error' => $e->getMessage(), 'code' => 500,];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
