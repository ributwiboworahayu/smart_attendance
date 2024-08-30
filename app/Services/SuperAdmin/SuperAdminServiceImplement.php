<?php

namespace App\Services\SuperAdmin;

use App\Repositories\Datatable\DatatableRepository;
use App\Repositories\SuperAdmin\SuperAdminRepository;
use Illuminate\Http\Request;
use LaravelEasyRepository\Service;

class SuperAdminServiceImplement extends Service implements SuperAdminService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected SuperAdminRepository $mainRepository;
    protected DatatableRepository $datatableRepository;

    public function __construct(
        SuperAdminRepository $mainRepository,
        DatatableRepository  $datatableRepository
    )
    {
        $this->mainRepository = $mainRepository;
        $this->datatableRepository = $datatableRepository;
    }


    public function getAdminUsersDatatables(Request $request): array
    {
        $datatables = $this->mainRepository->datatableQuery($request);
        $id = $datatables['id'];
        $query = $datatables['query'];
        $columns = $datatables['columns'];
        $actionRoutes = [
            'edit' => 'waste.liquid.update',
            'delete' => 'waste.liquid.delete',
            'detail' => 'waste.liquid.detail'
        ];

        return $this->datatableRepository->applyDatatables(
            $id,
            $request,
            $query,
            $columns,
            $actionRoutes
        );
    }
}
