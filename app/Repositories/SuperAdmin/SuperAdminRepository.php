<?php

namespace App\Repositories\SuperAdmin;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface SuperAdminRepository extends Repository
{

    public function datatableQuery(Request $request): array;
}
