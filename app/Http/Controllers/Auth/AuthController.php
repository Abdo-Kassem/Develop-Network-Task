<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Requests\AuthRequest\VerificationRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $registerRequest)
    {
        try {

            $user = $this->authService->register($registerRequest->validated());
            $user->accessToken = $user->createToken($user->id)->plainTextToken;
            return $this->successResponse($user, 'User Register Successfully', 201);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    public function login(LoginRequest $loginRequest)
    {
        try {

            $user = $this->authService->login($loginRequest->all());
            $user->accessToken = $user->createToken($user->id)->plainTextToken;
            
            return $this->successResponse($user, 'Login Success', 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        }
    }

    public function verify(VerificationRequest $verificationRequest)
    {
        try {

            $this->authService->verify($verificationRequest->all());

            return $this->successResponse(true, 'Account Verified Successfuly', 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        }
    }
}
