<?php

namespace App\Service\Auth;

use App\Models\Customer;
use App\Service\EloquentService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthService extends EloquentService
{

    public function login(array $payload): array|Exception
    {

        try {

            $user = Customer::query()->where("email", "=", $payload["email"])->first();

            if (!$user || !Hash::check($payload["password"], $user->password)) {
                return new Exception("The provided credential is incorrect");
            }

            $guard = Auth::guard("customer");
            $token = $guard->attempt($payload);
            $refreshToken = $guard->setTTL(7200)->attempt($payload);

            if (!$token && !$refreshToken) {
                return new Exception("Your credential is incorrect");
            }

            return [
                "token" => $token,
                "refresh_token" => $refreshToken,
                "expired_in" => $guard->factory()->getTTL(),
            ];

        } catch (Exception $exception) {
            return $exception;
        }

    }

}
