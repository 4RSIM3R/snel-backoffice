<?php

namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInquiryRequest;
use App\Models\Inquiry;
use App\Service\Inquiry\InquiryService;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerInquiryController extends Controller
{

    protected InquiryService $service;

    public function __construct(Inquiry $model)
    {
        $this->service = new InquiryService($model);
    }

    public function all(Request $request): JsonResponse
    {
        $page = $request->get("page");
        $result = $this->service->allByAuth('customer', true, $page);
        return WebResponseUtils::response($result, "Success Getting All Inquiry");
    }

    public function create(CreateInquiryRequest $request): JsonResponse
    {
        $payload = $request->except("photo");
        $payload["customer_id"] = Auth::guard("customer")->id();
        $result = $this->service->create($payload, $request->allFiles());
        return WebResponseUtils::response($result, "Success Creating Inquiry");
    }


}
