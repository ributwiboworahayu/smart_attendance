<?php

namespace App\Services\SuperAdmin;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface SuperAdminService extends BaseService
{

    public function getAdminUsersDatatables(Request $request): array;
}
