<?php

namespace App\Repositories\Unit;

use App\Models\Unit;
use Illuminate\Http\Request;
use LaravelEasyRepository\Implementations\Eloquent;

class UnitRepositoryImplement extends Eloquent implements UnitRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Unit $model;

    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

    public function datatableQuery(Request $request): array
    {
        $query = $this->model->select('id', 'name', 'description', 'created_at', 'updated_at');

        $columns = [
            'id',
            'name',
            'description',
            'created_at',
            'updated_at'
        ];

        return [
            'id' => 'id',
            'query' => $query,
            'columns' => $columns
        ];
    }
}
