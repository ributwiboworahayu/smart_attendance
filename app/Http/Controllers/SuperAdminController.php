<?php

namespace App\Http\Controllers;

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
        SuperAdminService $superAdminService
    )
    {
        $this->superAdminService = $superAdminService;
    }

    public function index(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('superadmin.index', $request->query());
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
