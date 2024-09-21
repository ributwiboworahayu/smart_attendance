<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Services\SuperAdmin\SuperAdminService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    protected SuperAdminService $superAdminService;

    public function __construct(
        SuperAdminService $superAdminService,
    )
    {
        $this->superAdminService = $superAdminService;
    }

    public function index(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('superadmin.index', $request->query());
    }

    public function units(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('superadmin.units', $request->query());
    }

    public function storeUnit(StoreUnitRequest $request): RedirectResponse
    {
        $result = $this->superAdminService->storeUnit($request);
        if (!$result['status']) return redirect()->back()->withError($result['message'])->withInput();
        return redirect()->route('superadmin.units')->withSuccess('Unit created successfully');
    }

    public function unitDatatables(Request $request): JsonResponse|RedirectResponse
    {
        $result = $this->superAdminService->getUnitDatatables($request);
        if (!$result['ajax']) return redirect()->route('superadmin.units')->withErrors('Something went wrong');
        return response()->json($result);
    }

    public function adminUsers(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('superadmin.users', $request->query());
    }

    public function adminUsersDatatables(Request $request): JsonResponse|RedirectResponse
    {
        $result = $this->superAdminService->getAdminUsersDatatables($request);
        if (!$result['ajax']) return redirect()->route('admin.users')->withErrors('Something went wrong');
        return response()->json($result);
    }
}
