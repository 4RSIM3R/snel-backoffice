<?php

namespace App\Service\Site;

use App\Service\EloquentService;
use Illuminate\Database\Eloquent\Model;

class CustomerSiteService extends EloquentService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
