<?php

namespace App\Service\Ticket;

use App\Models\Ticket;
use App\Service\EloquentService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmployeeTicketService extends EloquentService
{

    protected Model $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function get(string $start, string $end, $id): Collection|Exception|array
    {

        try {
            $statuses = ['CUSTOMER_APPROVED', 'WORKING', 'NEED_ADMIN_REVIEW', 'DONE'];

            return Ticket::query()->whereBetween('date', [$start, $end])
                ->where('employee_id', $id)
                ->whereIn('status', $statuses)
                ->with(['customer'])
                ->get(); // Return the result
        } catch (Exception $exception) {
            return $exception;
        }

    }

}
