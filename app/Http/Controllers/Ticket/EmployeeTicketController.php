<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitTicketRequest;
use App\Models\Ticket;
use App\Service\Ticket\EmployeeTicketService;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeeTicketController extends Controller
{

    protected EmployeeTicketService $service;

    public function __construct(Ticket $model)
    {
        $this->service = new EmployeeTicketService($model);
    }

    public function all(Request $request): JsonResponse
    {
        $start = $request->get("start", Carbon::now()->firstOfMonth());
        $end = $request->get("end", Carbon::now()->lastOfMonth());
        $id = Auth::guard("employee")->id();
        $result = $this->service->get($start, $end, $id);
        return WebResponseUtils::response($result, "Success Getting All Ticket");
    }

    public function detail($id): JsonResponse
    {
        $result = $this->service->findById($id, ['employee', 'customer', 'site', 'histories']);
        return WebResponseUtils::response($result, "Success Getting All Ticket");
    }

    public function submit(SubmitTicketRequest $request)
    {

    }


}
