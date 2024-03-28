<?php

namespace App\Service\Auth;

use App\Models\Customer;
use App\Service\EloquentService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthService
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

            if (!$token) {
                return new Exception("Your credential is incorrect");
            }

            return [
                "token" => $token,
                "expired_in" => $guard->factory()->getTTL(),
            ];

        } catch (Exception $exception) {
            return $exception;
        }

    }

    public function logout(): bool|Exception
    {
        try {
            Auth::guard("customer")->logout();

            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }


}
