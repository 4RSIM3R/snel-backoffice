<?php

namespace App\Service;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentService
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($paginate = false, $page = 1, $relations = [], $whereConditions = [], string|null $sort = null): Collection|Exception|array
    {
        try {
            $model = $this->model::query()
                ->where($whereConditions)
                ->with($relations);

            if ($sort) {
                $order = 'ASC';

                if (strncmp($sort, '-', 1) === 0) {
                    $sort = substr($sort, 1);
                    $order = 'DESC';
                }

                $model = $model->orderBy($sort, $order);
            } else {
                $model = $model->orderBy('id', 'DESC');
            }

            if ($paginate) {
                $model = $model->paginate(10, ["*"], "page", $page);

                return [
                    'data' => $model->items(),
                    'prev_page' => (int)mb_substr($model->previousPageUrl(), -1) ?: null,
                    'current_page' => $model->currentPage(),
                    'next_page' => (int)mb_substr($model->nextPageUrl(), -1) ?: null
                ];
            } else {
                return $model->get();
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function allByAuth(string $guard, $paginate = false, $page = 1): Collection|Exception|array
    {
        try {
            $modelId = Auth::guard($guard)->id();
            if ($paginate) {
                $model = $this->model::query()
                    ->orderBy('id', 'desc')
                    ->where($guard . '_id', $modelId)
                    ->paginate(10, ["*"], "page", $page);

                return [
                    'data' => $model->items(),
                    'prev_page' => (int)mb_substr($model->previousPageUrl(), -1) ?: null,
                    'current_page' => $model->currentPage(),
                    'next_page' => (int)mb_substr($model->nextPageUrl(), -1) ?: null
                ];
            } else {
                return $this->model::query()->where($guard . '_id', $modelId)->get();
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function findById($id, $relations = []): Model|Builder|Exception
    {
        try {
            if (!$model = $this->model::query()->where("id", "=", $id)->with($relations)->first()) {
                return new Exception(sprintf('Data with Id %s Not Found', $id));
            }

            return $model;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function findByIdAuth(string $guard, int $id): Model|Collection|Builder|Exception|array
    {
        try {
            $modelId = Auth::guard($guard)->id();

            if (!$model = $this->model::query()->where($guard . '_id', $modelId)->find($id)) {
                return new Exception(sprintf('Data with Id %s Not Found', $id));
            }

            return $model;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function search(string $key, string|null $value = null): Collection|Exception|array|null
    {
        try {
            if (is_null($value)) {
                return null;
            }

            return $this->model::query()
                ->where($key, 'like', '%' . $value . '%')
                ->get(['id', $key]);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function create(array $params, $image = []): Model|Builder|Exception|null
    {
        try {
            DB::beginTransaction();

            $model = $this->model::query()->create($params);

            if (!is_null($image) && count($image) > 0) {
                foreach ($image as $key => $value) {
                    $model->addMultipleMediaFromRequest([$key])->each(function ($image) use ($key) {
                        $image->toMediaCollection($key);
                    });
                }
            }

            DB::commit();

//            ResponseCache::clear();

            return $model->fresh();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }

    public function update(int $id, array $params, $image = null): Model|Builder|Exception
    {
        try {
            DB::beginTransaction();

            if (!$model = $this->model::query()->where('id', '=', $id)->first()) {
                return new Exception(sprintf('Data with Id %s Not Found', $id));
            }

            $model->update($params);

            if (!is_null($image)) {
                foreach ($image as $key => $value) {
                    $model->clearMediaCollection();
                    $model->addMultipleMediaFromRequest([$key])->each(function ($image) use ($key) {
                        $image->toMediaCollection($key);
                    });
                }
            }

            DB::commit();
            return $model;
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }

    public function delete(int $id): bool|Exception
    {
        try {
            DB::beginTransaction();

            if (!$model = $this->model::query()->where('id', $id)->first()) {
                return new Exception(sprintf('Data with Id %s Not Found', $id));
            }

            $model->delete();

            DB::commit();

//            ResponseCache::clear();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }


}
