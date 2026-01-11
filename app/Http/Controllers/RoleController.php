<?php

namespace App\Http\Controllers;

use App\Helpers\JWTToken;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:role-list|role-create|role-edit|role-delete'], ['only' => ['RolePageView']]);
        $this->middleware(['permission:permission-list|permission-create|permission-edit|permission-delete'], ['only' => ['PermissionPageView']]);

    }

    public function RolePageView(Request $request)
    {
        // check cookie token
        $token = $request->cookie('BackendLogin');
        if(!$token){
            return redirect(route('backend.login'));
        }else{
            $user = JWTToken::ReadToken($token);
            if(!$user){
                return redirect(route('backend.login'));
            }else{
                $id = $user->userID;
                $user = user::find($id);
                return view("Backend.Pages.Roles.Role-Page", compact('user'));
            }
        }
    }

    public function PermissionPageView(Request $request)
    {
        // check cookie token
        $token = $request->cookie('BackendLogin');
        if(!$token){
            return redirect(route('backend.login'));
        }else{
            $user = JWTToken::ReadToken($token);
            if(!$user){
                return redirect(route('backend.login'));
            }else{
                $id = $user->userID;
                $user = user::find($id);
                return view("Backend.Pages.Permissions.Permissions-Page", compact('user'));
            }
        }
    }



    // create-roles
    public function createRoles(Request $request)
    {
        try {
            $request->validate([
                'role_name' => 'required|string',
                'status' => 'required',
                'permission_ids' => 'array',
            ]);

            // Check if role already exists
            $check = Role::where('name', $request->input('role_name'))->first();
            if ($check) {
                return ResponseHelper::Out('error', 'Role already exists', null, 200); // Use 409 Conflict status
            }
            // Create role
            $role = Role::create([
                'name' => $request->input('role_name'),
                'status' => $request->input('status'),
            ]);
            // Convert permission IDs to names
            $permissions = Permission::whereIn('id', $request->input('permission_ids'))->pluck('name');
            // Sync permissions
            $role->syncPermissions($permissions);
            return ResponseHelper::Out('success', 'Role created successfully', null, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // get-roles
    public function getRoles()
    {
        try {
            $roles = Role::all();
            return ResponseHelper::Out('success', 'Roles fetched successfully', $roles, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // get-role-by-id
    public function getRoleById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            $role = Role::where('id', $request->input('id'))->first();
            if ($role) {
                return ResponseHelper::Out('success', 'Role fetched successfully', $role, 200);
            }else {
                return ResponseHelper::Out('error', 'Role not found', null, 200);
            }
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // get Role has permissions by id
    public function getRoleHasPermissionsById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
             $role = Role::where('id', $request->input('id'))->first();
            if ($role) {
                // Check if role already exists
                $check = Role::where('id', '=', $request->input('id'))->first();
                if ($check) {
                    $permissions = $role->permissions;
                    return ResponseHelper::Out('success', 'Successfully get permissions', $permissions, 200);
                }else{
                    return ResponseHelper::Out('error', 'Role is not found', null, 200);
                }
            }else {
                return ResponseHelper::Out('error', 'Role not found', null, 200);
            }
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // update-roles
    public function updateRoles(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:roles,id',
                'role_name' => 'required|string|unique:roles,name,' . $request->id,
                'status' => 'required',
                'permission_ids' => 'array',
            ]);

            // find user id
            $token = $request->cookie('BackendLogin');
            if (!$token) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $userData = JWTToken::ReadToken($token);
            if (!$userData) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            // only super admin can update super admin not other roles
            $user = User::find($userData->userID);
            if (!$user->hasRole('Super Admin') && $request->input('role_name') === 'Super Admin') {
                return ResponseHelper::Out('error', 'Only Super Admin can update Super Admin role', null, 403);
            }
            // Find the role by ID
            $role = Role::findOrFail($request->input('id'));
            // Update the role name
            $role->update([
                'name' => $request->input('role_name'),
                'status' => $request->input('status'),
            ]);

            // Convert permission IDs to names
            $permissions = Permission::whereIn('id', $request->input('permission_ids'))->pluck('name')->toArray();

            // Sync permissions
            $role->syncPermissions($permissions);

            return ResponseHelper::Out('success', 'Role updated successfully', null, 200);

        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }

    // create-permissions
    public function createPermissions(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
            ]);
            $check = Permission::where('name', '=', $request->input('name'))->first();
            if($check){
                return ResponseHelper::Out('error', 'Permission already exists', null, 200);
            }else{
                $permission = Permission::create([
                    'name' => $request->input('name'),
                ]);
                return ResponseHelper::Out('success', 'Permission created successfully', null, 200);
            }
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // get-permissions
    public function getPermissions()
    {
        try{
            $permissions = Permission::all();
            return ResponseHelper::Out('success', 'Permissions fetched successfully', $permissions, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // get-permission-by-id
    public function getPermissionById(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required',
            ]);
            $permission = Permission::where('id', '=', $request->input('id'))->first();
            if($permission){
                return ResponseHelper::Out('success', 'Permission fetched successfully', $permission, 200);
            }else{
                return ResponseHelper::Out('error', 'Permission not found', null, 200);
            }
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // update-permission-by-id
    public function PermissionUpdateById(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required',
                'name' => 'required',
            ]);
            $permission = Permission::where('id', '=', $request->input('id'))->first();
            if($permission){
                // check the permission name is already exists or not skip the current permission name
                $check = Permission::where('name', '=', $request->input('name'))->where('id', '!=', $request->input('id'))->first();
                if($check){
                    return ResponseHelper::Out('error', 'Permission already exists', null, 200);
                }else{
                    $permission->name = $request->input('name');
                    $permission->save();
                    return ResponseHelper::Out('success', 'Permission updated successfully', null, 200);
                }
            }else{
                return ResponseHelper::Out('error', 'Permission not found', null, 200);
            }
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // delete-permission-by-id
    public function PermissionDeleteById(Request $request)
    {
        try{
            $request->validate([
                'id' => 'required',
            ]);
            $permission = Permission::where('id', '=', $request->input('id'))->first();
            if($permission){
                $permission->delete();
                return ResponseHelper::Out('success', 'Permission deleted successfully', null, 200);
            }else{
                return ResponseHelper::Out('error', 'Permission not found', null, 200);
            }
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // role-delete-by-id
    public function RoleDeleteById(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'id' => 'required|', // Ensure the role exists in the database
            ]);

            // Retrieve the role ID from the request
            $role_id = $request->input('id');

            // Check if the role is associated with any user in the 'model_has_roles' table
            $roleAssociation = DB::table('model_has_roles')
                ->where('role_id', '=', $role_id)
                ->exists(); // Check if any user has this role

            if ($roleAssociation) {
                // If the role is associated with users, do not delete it
                return ResponseHelper::Out('error', 'Role is assigned to users, cannot delete', null, 200);
            } else {
                // If the role is not associated with any user, proceed to delete it
                $role = Role::findOrFail($role_id); // Use findOrFail for proper error handling
                $role->delete(); // Delete the role from the database
                return ResponseHelper::Out('success', 'Role deleted successfully', null, 200);
            }

        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }

}
