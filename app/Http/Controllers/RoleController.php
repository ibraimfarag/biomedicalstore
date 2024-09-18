<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Department;


class RoleController extends Controller
{
    // Display list of roles
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $departments = Department::all();

        

        return view('roles.index', compact('roles','permissions','departments'));
    }

    // Show the form to create a new role
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    // Store the new role
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    // Show the form to edit a role and its permissions
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    // Update the role and its permissions
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    // Delete a role
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }


    public function assignToDepartment(Request $request)
    {
        $roles = Role::all();
        $departments = Department::all();
        
        $currentDepartment = null;
        $selectedRoles = [];
    
        if ($request->has('department')) {
            $currentDepartment = Department::find($request->department);
            if ($currentDepartment) {
                $selectedRoles = $currentDepartment->roles->pluck('id')->toArray();
            }
        }
    
        $data = [
            'roles' => $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            }),
            'departments' => $departments->map(function ($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                ];
            }),
            'selectedRoles' => $selectedRoles,
        ];
    
        return response()->json($data);
    }
            

    // Store role assignments to departments
    public function storeAssignments(Request $request)
    {
        $request->validate([
            'department' => 'required|exists:departments,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $department = Department::find($request->department);

           // Log department and roles
//    dd($department , $request->roles);


        $department->roles()->sync($request->roles);

        return redirect()->route('roles.index')->with('success', 'Roles assigned to department successfully.');
    }
}
