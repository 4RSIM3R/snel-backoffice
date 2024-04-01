<?php

namespace App\Service\Unit;

use App\Service\EloquentService;
use Illuminate\Database\Eloquent\Model;

class UnitService extends EloquentService
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }


}
