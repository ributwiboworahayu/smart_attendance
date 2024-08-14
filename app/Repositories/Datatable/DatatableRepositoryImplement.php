<?php

namespace App\Repositories\Datatable;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Datatable;

class DatatableRepositoryImplement extends Eloquent implements DatatableRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Datatable $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
