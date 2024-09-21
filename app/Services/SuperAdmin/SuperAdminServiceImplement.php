<?php

namespace App\Services\SuperAdmin;

use App\Repositories\Datatable\DatatableRepository;
use App\Repositories\SuperAdmin\SuperAdminRepository;
use App\Repositories\Unit\UnitRepository;
use App\Traits\ServiceResponser;
use Exception;
use Illuminate\Http\Request;
use LaravelEasyRepository\Service;

class SuperAdminServiceImplement extends Service implements SuperAdminService
{
    use ServiceResponser;

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected SuperAdminRepository $mainRepository;
    protected DatatableRepository $datatableRepository;
    protected UnitRepository $unitRepository;

    public function __construct(
        SuperAdminRepository $mainRepository,
        DatatableRepository  $datatableRepository,
        UnitRepository       $unitRepository
    )
    {
        $this->mainRepository = $mainRepository;
        $this->datatableRepository = $datatableRepository;
        $this->unitRepository = $unitRepository;
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

    public function getUnitDatatables(Request $request): array
    {
        $datatables = $this->unitRepository->datatableQuery($request);
        $id = $datatables['id'];
        $query = $datatables['query'];
        $columns = $datatables['columns'];
        $actionRoutes = [];

        return $this->datatableRepository->applyDatatables(
            tableIdColumnName: $id,
            request: $request,
            query: $query,
            columns: $columns,
            actionRoutes: $actionRoutes,
            hideIdColumn: false
        );
    }

    public function storeUnit(Request $request): array
    {
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];

        try {
            $this->unitRepository->create($data);
            return self::finalResultSuccess();
        } catch (Exception $e) {
            return self::finalResultFail($e, $e->getMessage());
        }
    }
}
