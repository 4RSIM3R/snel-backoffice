<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Service\Ticket\CustomerTicketService;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerTicketController extends Controller
{

    protected CustomerTicketService $service;

    public function __construct(Ticket $model)
    {
        $this->service = new CustomerTicketService($model);
    }

    public function all(Request $request): JsonResponse
    {
        $page = $request->get('page');
        $start = $request->get("start", Carbon::now()->firstOfMonth());
        $end = $request->get("end", Carbon::now()->lastOfMonth());

        $conditions = [
            ['date', '>=', $start],
            ['date', '<=', $end],
            ['customer_id', '=', Auth::guard('customer')->id()],
        ];

        $result = $this->service->all(true,  $page, [], $conditions);
        return WebResponseUtils::response($result, "Success Getting All Ticket");
    }

    public function detail($id)
    {

    }

}
