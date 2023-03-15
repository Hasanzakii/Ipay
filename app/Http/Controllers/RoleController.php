<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ValidateSignature;
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
    
    #RevokeUserRole
    public function RevokeUserRole(Request $request)
    {
        Validator::make($request->all(), [
            'permission_id' => 'required',
            'user_id' => 'required'
        ])->validate();
        $permission_id = $request->permission_id;
        $permission = Permission::where('id', $permission_id)->first();
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        $user->revokePermissionTo($permission);
        $result = $user->hasPermissionTo($permission);
        if ($result == false) {
            return response()->json([
                'message' => "permission Revcoked succesfully",
            ]);
        }
        return response()->json([
            'result ' => "failed to revoke",

        ]);
    }

    # Delete Role
    public function DeleteRole(Request $request)
    {
        Validator::make($request->all(), [
            'role_id' => 'required'
        ])->validate();
        $role = Role::where('id', $request->role_id)->first();
        $role->delete();
        return response()->json([
            "message" => "Role Deleted Successfully"
        ]);
    }

    #Assign Role to user
    public function AssignRoleToUser(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ])->validate();
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

    #RemoveRole
    public function RemoveRole(Request $request)
    {
        Validator::make($request->all(), [
            'role_id' => 'required',
            'user_id' => 'required'
        ])->validate();
        $role_id = $request->role_id;
        $role = Role::where('id', $role_id)->first();
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        $user->removeRole($role);
        $result = $user->hasRole($role);
        if ($result == false) {
            return response()->json([
                "result" => $result,
                "message" => "Role removed successfully"
            ]);
        }
    }


    # if Role Has Permission
    public function RoleHasPermission(Request $request)
    {
        Validator::make($request->all(), [
            'permission_id' => 'required',
            'role_id' => 'required'
        ])->validate();
        $permission_id = $request->permission_id;
        $permission = Permission::where('id', $permission_id)->first();
        $role_id = $request->role_id;
        $role = Role::where('id', $role_id)->first();
        if ($role && $permission) {
            $result = $role->hasDirectPermission($permission);
            if ($result == true) {
                return response()->json([
                    'result' => $result,
                    'message' => 'Role Has ' . $permission . "permission"
                ]);
            }
            return response()->json([
                'result' => $result,
                'message' => 'Role hasnt ' . $permission . " permissions"
            ]);
        } else {
            return response()->json([
                'result' => "false",
                "message" => "No User Or Roles Exists With this specifications "
            ], 404);
        }
    }

    # if User Has Roles
    public function UserHasRole(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ])->validate();
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        $role_id = $request->role_id;
        $role = Role::Where('id', $role_id)->first();
        if ($user && $role) {
            $result = $user->hasRole($role);
            if ($result == true) {
                return response()->json([
                    'result' => $result,
                    'message' => 'User Has ' . $role->name . " Role"
                ]);
            }
            return response()->json([
                'result' => $result,
                'message' => 'User hasnt ' . $role->name . " Role"
            ]);
        } else {
            return response()->json([
                'result' => "false",
                "message" => "No User Or Roles Exists With this specifications "
            ], 404);
        }
    }

    # if User Has Permission
    public function UserHasPermission(Request $request)
    {
        Validator::make($request->all(), [
            'permission_id' => 'required|exists:permissions',
            'user_id' => 'required'
        ])->validate();
        $permission_id = $request->permission_id;
        $permission = Permission::where('id', $permission_id)->first();
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        if ($user && $permission) {
            $result = $user->hasDirectPermission($permission);
            if ($result == true) {
                return response()->json([
                    'result' => $result,
                    'message' => 'User Has ' . $permission . "permission"
                ]);
            }
            return response()->json([
                'result' => $result,
                'message' => 'User hasnt ' . $permission . " permissions"
            ]);
        } else {
            return response()->json([
                'result' => "false",
                "message" => "No User Or Permission Exists With this specifications "
            ], 404);
        }
    }

    # User has Any of an array of permissions
    public function UserHasThisPermissions(Request $request)
    {

        Validator::make($request->all(), [
            'permission_ids' => 'required|array',
            'user_id' => 'required'
        ])->validate();
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        $permission_ids = $request->permission_ids;
        $permissions = Permission::whereIn('id', $permission_ids)->get();
        $result = $user->hasAnyPermission($permissions);
        return response()->json([
            "result" => $result,
        ]);
    }

    # sync Multiple Permission To role
    public function SMPR(Request $request)
    {
        Validator::make($request->all(), [
            'permission_ids' => 'required|array',
            'role_id' => 'required'
        ])->validate();
        $role_id = $request->role_id;
        $role = Role::where('id', $role_id)->first();
        // $permission_ids = $request->input('permission_ids');
        $permission_ids = $request->permission_ids;
        // where() is used to filter results based on a single value for a single column,
        //  while whereIn() is used to filter results based on multiple values for a single column
        $permissions = Permission::whereIn('id', $permission_ids)->get();
        $result = $role->syncPermissions($permissions);

        return response()->json([
            "result" => $result,
        ]);
    }

    # sync Multiple Permission To User
    public function SMPU(Request $request)
    {
        Validator::make($request->all(), [
            'permission_ids' => 'required|array',
            'user_id' => 'required'
        ])->validate();
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        // $permission_ids = $request->input('permission_ids');
        $permission_ids = $request->permission_ids;
        // where() is used to filter results based on a single value for a single column,
        //  while whereIn() is used to filter results based on multiple values for a single column
        $permissions = Permission::whereIn('id', $permission_ids)->get();
        $result = $user->syncPermissions($permissions);

        return response()->json([
            "result" => $result,
        ]);
    }
}
