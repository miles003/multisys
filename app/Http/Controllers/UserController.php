<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Exceptions\ThrottleException;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    /**
     * Authenticate User function
     *
     * @param Request $request Request Data
     * 
     * @return void
     */
    public function authenticate(LoginRequest $request)
    {
        $this->checkTooManyFailedAttempts();
        try{
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                RateLimiter::hit($this->throttleKey(), 300);
                return response()->json(['message' => 'Invalid Credentials'], 401);
            }
            RateLimiter::clear($this->throttleKey());

            return response()->json(['access_token' => $token]);
        }catch(\Throwable $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        throw new ThrottleException('Too many Attemps your account is locked');
    }
}
