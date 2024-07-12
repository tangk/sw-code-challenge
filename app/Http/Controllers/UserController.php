<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
            $this->response['data'] = $user->toArray();
        } catch (Exception $e) {
            $this->response = [ 'error' => $e->getMessage(), 'code' => 500,];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
