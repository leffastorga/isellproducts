<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticatedController extends BaseController
{
    /**
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LoginRequest $request){
        $user = User::where('email', $request->email)->first();

        //Attempt login
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('WRONG_USER_PASS');
        }

        //UPDATE last ip and timestamp of login
        $user->last_ip = $request->ip();
        $user->last_login = now();
        $user->save();

        return $this->sendResponse($user->createToken($request->email)->plainTextToken);
    }
}