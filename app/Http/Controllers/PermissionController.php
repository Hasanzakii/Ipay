<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function CreatePermission(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name'

        ]);
        $permision = Permission::create([
            'name' => $request->name
        ]);
        return response()->json([
            'message' => 'Permission created sucessfully',
            'Permission' => $permision
        ]);
    }
    public function GetPermission()
    {
        $permissions = Permission::all();
        return response()->json([
            $permissions
        ]);
    }
}
