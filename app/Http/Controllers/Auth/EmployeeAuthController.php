<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Service\Auth\EmployeeAuthService;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;

class EmployeeAuthController extends Controller
{

    private EmployeeAuthService $service;

    public function __construct()
    {
        $this->service = new EmployeeAuthService();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login($request->all());
        return WebResponseUtils::response($result, "Employee Success Login");
    }

    public function logout(): JsonResponse
    {
        $result = $this->service->logout();
        return WebResponseUtils::response($result, "Employee Success Login");
    }

}
