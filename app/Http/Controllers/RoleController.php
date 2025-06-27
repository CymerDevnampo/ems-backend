<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function getRoles()
    {
        $userRoleId = Auth::user()->role_id;

        if ($userRoleId === 1) {
            $roles = Role::where('id', '!=', 1)->get();
        } else {
            $roles = Role::get();
        }

        return response()->json($roles);
    }

}
