<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Service\Site\CustomerSiteService;
use App\Utils\WebResponseUtils;
use Illuminate\Http\JsonResponse;

class CustomerSiteController extends Controller
{

    protected CustomerSiteService $service;

    public function __construct(Site $model)
    {
        $this->service = new CustomerSiteService($model);
    }

    public function all(): JsonResponse
    {
        $result = $this->service->allByAuth('customer',true);
        return WebResponseUtils::response($result, "Success Getting All Site");
    }

    public function detail($id): JsonResponse
    {
        $result = $this->service->findById($id, ['units']);
        return WebResponseUtils::response($result, "Success Getting Site Detail");
    }

}
