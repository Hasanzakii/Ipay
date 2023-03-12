<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    #CreateRole
    public function CreateRole(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:roles,name'

        ])->validate();
        $role = Role::create([
            'name' => $request->name
        ]);
        return response()->json([
            'message' => 'Role Created Sucessfully',
            'Role' => $role
        ]);
    }

    #Assign Role to user
    public function AssignRoleToUser(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ]);
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        $role_id = $request->role_id;
        $role = Role::where('id', $role_id)->first();
        if (!$role) {
            return response()->json(['error' => 'There is no role with ' . $role_id . ' ID '], 404);
        }
        if (!$user) {
            return response()->json(['error' => 'There is no user with ' . $user_id . ' ID '], 404);
        }
        $user->assignRole($role);
        $result = $user->hasRole($role);

        return response()->json([
            'user' => $user,
            'role' => $role,
            'result' => $result,
            'message' => 'Role assigned',
        ]);
    }

    #Assign permission to each role
    public function AssignPermissionToRole(Request $request)
    {
        Validator::make($request->all(), [
            'permission_id' => 'required',
            'role_id' => 'required'
        ])->validate();

        $permission_id = $request->permission_id;
        $permission = Permission::where('id', $permission_id)->first();
        $role_id = $request->role_id;
        $role = Role::where('id', $role_id)->first();

        if (!$role) {
            return response()->json(['error' => 'There is no role with' . $role_id . ' ID '], 404);
        }
        if (!$permission) {
            return response()->json(['error' => 'There is no role with' . $permission_id . ' ID '], 404);
        }
        $role->givePermissionTo($permission);
        $result = $role->hasDirectPermission($permission);
        return response()->json([
            'role' => $role,
            'permission' => $permission,
            'result' => $result,
            'message' => 'permission assigned to Role',
        ]);
    }


    #Assign Permission ToU ser

    public function AssignPermissionToUser(Request $request)
    {
        Validator::make($request->all(), [
            'permission_id' => 'required',
            'user_id' => 'required'
        ])->validate();
        $permission_id = $request->permission_id;
        $permission = Permission::where('id', $permission_id)->first();
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return response()->json(['error' => 'There is no user with' . $user_id . ' ID '], 404);
        }
        if (!$permission) {
            return response()->json(['error' => 'There is no role with' . $permission_id . ' ID '], 404);
        }
        $user->givePermissionTo($permission);
        $result = $user->hasDirectPermission($permission);
        return response()->json([
            'user' => $user,
            'permission' => $permission,
            'result' => $result,
            'message' => 'permission assigned',
        ]);
    }


    # Get All Permissions
    public function GetPermissions()
    {
        $permissions = Permission::all();
        return response()->json([$permissions]);
    }

    # Get All Roles
    public function GetRolles()
    {
        $roles = Role::all();
        return response()->json([$roles]);
    }
}
