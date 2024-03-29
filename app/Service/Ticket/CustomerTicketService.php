<?php

namespace App\Service\Ticket;

use App\Models\Ticket;
use App\Service\EloquentService;
use Illuminate\Database\Eloquent\Model;

class CustomerTicketService extends EloquentService
{

    protected Model $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }



}
