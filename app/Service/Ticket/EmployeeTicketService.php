<?php

namespace App\Service\Ticket;

use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Service\EloquentService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeTicketService extends EloquentService
{

    protected Model $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function get(string $start, string $end, $id, array $types, string $status): Collection|Exception|array
    {
        try {

            return Ticket::query()->whereBetween('date', [$start, $end])
                ->where('employee_id', $id)
                ->where('status', $status)
                ->whereIn('type', $types)
                ->with(['customer', 'site'])
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }

    }

    public function submitWork(array $payload, $image = [])
    {
        try {
            DB::beginTransaction();

            $history = TicketHistory::query()->create($payload);
            Ticket::query()->where('id', $payload["id"])->update(["status" => "NEED_ADMI_REVIEW"]);

            if (!is_null($image) && count($image) > 0) {
                foreach ($image as $key => $value) {
                    $history->addMultipleMediaFromRequest([$key])->each(function ($image) use ($key) {
                        $image->toMediaCollection($key);
                    });
                }
            }

            DB::commit();

            return $history->fresh();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }



}
