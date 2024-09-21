<?php

namespace App\Repositories\Unit;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface UnitRepository extends Repository
{

    public function datatableQuery(Request $request): array;
}
