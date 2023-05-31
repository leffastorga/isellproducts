<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterController extends BaseController
{
    /**
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request){
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'email_verified_at' => now(), //this must be with email verification flow
            'password' => bcrypt($request->password),
            'is_admin' => false,
            'is_active' => true
        ]);
        Log::info('Email to user welcome to the ecommerce site!');
        return $this->sendResponse('OK');
    }
}
