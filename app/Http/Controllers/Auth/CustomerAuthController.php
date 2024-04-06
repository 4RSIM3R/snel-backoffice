<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Service\Auth\CustomerAuthService;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;

class CustomerAuthController extends Controller
{

    private CustomerAuthService $service;

    public function __construct()
    {
        $this->service = new CustomerAuthService();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login($request->all());
        return WebResponseUtils::response($result, "Customer Success Login");
    }

    public function logout(): JsonResponse
    {
        $result = $this->service->logout();
        return WebResponseUtils::response($result, "Customer Success Login");
    }

}
