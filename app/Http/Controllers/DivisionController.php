<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;

class DivisionController extends Controller
{
    public function index()
    {
        // Fetch all divisions sorted alphabetically
        $divisions = Division::orderBy('name', 'asc')->get();
        return view('divisions.index', compact('divisions'));
    }

    public function create(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|unique:divisions,name',
        ]);

        // Create a new division
        Division::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Division created successfully.');
    }

    public function delete($id)
    {
        // Find and delete the division
        $division = Division::findOrFail($id);
        $division->delete();

        return redirect()->back()->with('success', 'Division deleted successfully.');
    }
}
