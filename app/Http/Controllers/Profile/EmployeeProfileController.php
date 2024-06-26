<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{

    public function get(): JsonResponse
    {
        $user = Auth::guard('employee')->user();
        return WebResponseUtils::response($user, "Success Getting All Ticket");
    }

}
