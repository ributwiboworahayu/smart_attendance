<?php

namespace App\Repositories\SuperAdmin;

use App\Models\User;
use App\Traits\DatatableResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelEasyRepository\Implementations\Eloquent;

class SuperAdminRepositoryImplement extends Eloquent implements SuperAdminRepository
{
    use DatatableResponser;

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function datatableQuery(Request $request): array
    {
        $query = $this->user
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'units.name as unit_name',
                'branches.name as branch_name',
                'sub_branches.name as sub_branch_name',
            ])->join('user_admin_units', 'users.id', '=', 'user_admin_units.user_id')
            ->join('units', 'user_admin_units.unit_id', '=', 'units.id')
            ->join('branches', 'user_admin_units.branch_id', '=', 'branches.id')
            ->join('sub_branches', 'user_admin_units.sub_branch_id', '=', 'sub_branches.id');

        $columns = [
            'users.name',
            'users.email',
            'units.name',
            'branchs.name',
            'sub_branchs.name',
        ];

        $id = 'id';
        return self::queryDatatable($id, $query, $columns);
    }
}
