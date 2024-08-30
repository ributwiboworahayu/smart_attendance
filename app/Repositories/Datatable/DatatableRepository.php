<?php

namespace App\Repositories\Datatable;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface DatatableRepository extends Repository
{

    public function applyDataTables(
        string  $tableIdColumnName,
        Request $request,
                $query,
        array   $columns,
        array   $actionRoutes = [],
        array   $groupBy = [],
        string  $havingRaw = '',
        bool    $hideIdColumn = true
    ): array;
}
