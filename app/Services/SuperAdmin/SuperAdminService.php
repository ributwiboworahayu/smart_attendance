<?php

namespace App\Services\SuperAdmin;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface SuperAdminService extends BaseService
{

    public function getAdminUsersDatatables(Request $request): array;

    public function getUnitDatatables(Request $request): array;

    public function storeUnit(Request $request): array;
}
