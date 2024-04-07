<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckinTicketRequest;
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

    public function allRegular(Request $request): JsonResponse
    {
        $start = $request->get("start", Carbon::now()->firstOfMonth());
        $end = $request->get("end", Carbon::now()->lastOfMonth());
        $status = $request->get("status", "CUSTOMER_APPROVED");
        $id = Auth::guard("employee")->id();
        $result = $this->service->get($start, $end, $id, ['REGULAR', 'PRIORITY'], $status);
        return WebResponseUtils::response($result, "Success Getting All Ticket");
    }

    public function allRecording(Request $request): JsonResponse
    {
        $start = $request->get("start", Carbon::now()->firstOfMonth());
        $end = $request->get("end", Carbon::now()->lastOfMonth());
        $status = $request->get("status", "CUSTOMER_APPROVED");
        $id = Auth::guard("employee")->id();
        $result = $this->service->get($start, $end, $id, ['RECORDING'], $status);
        return WebResponseUtils::response($result, "Success Getting All Ticket");
    }

    public function detail($id): JsonResponse
    {
        $result = $this->service->findById($id, ['employee', 'customer', 'site', 'histories']);
        return WebResponseUtils::response($result, "Success Getting All Ticket");
    }

    function checkin($id, CheckinTicketRequest $request): JsonResponse
    {
        $status = $request->get("status");
        $result = $this->service->update($id, ["status" => $status]);
        return WebResponseUtils::response($result, "Success Check-In Ticket");
    }

    public function submit($id, SubmitTicketRequest $request): JsonResponse
    {
        $payload = $request->except("photo");
        $payload["employee_id"] = Auth::guard("employee")->id();
        $payload["ticket_id"] = $id;
        $result = $this->service->submitWork($payload, $request->allFiles());
        return WebResponseUtils::response($result, "Success Creating Inquiry");

    }


}
