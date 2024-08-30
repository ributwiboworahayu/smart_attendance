<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        dd(User::where('id', Auth::id())->whereHas('roles', function ($query) {
            $query->where('key', 'superadmin');
        })->get()->toArray());
    }
}
