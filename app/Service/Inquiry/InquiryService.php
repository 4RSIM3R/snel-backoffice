<?php

namespace App\Service\Inquiry;

use App\Models\Inquiry;
use App\Service\EloquentService;
use Illuminate\Database\Eloquent\Model;

class InquiryService extends EloquentService
{

    protected Model $model;

    public function __construct(Inquiry $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
