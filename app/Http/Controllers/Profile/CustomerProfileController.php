<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{

    public function get(): JsonResponse
    {
        $user = Auth::guard('customer')->user()->with(['company']);
        return WebResponseUtils::response($user, "Success Getting All Ticket");
    }

}
