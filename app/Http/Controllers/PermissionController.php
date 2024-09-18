<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    // Display list of permissions
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    // Show the form to create a new permission
    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);
    
        // Create the permission
        $permission = Permission::create(['name' => $request->name]);
    
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return response()->json(['success' => true, 'permission' => $permission]);
        }
    
        // Redirect back with success message for non-AJAX requests
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }
    

    // Show the form to edit a permission
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit', compact('permission'));
    }

    // Update the permission
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    // Delete a permission
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
