<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|unique:items',
            'definition' => 'required',
            'active' => 'required|boolean',
        ]);

        // Create the new item
        $item = Item::create($request->all());

        // Create the corresponding stock entry with quantity 0
        Stock::create([
            'item_id' => $item->id,
            'quantity' => 0,
        ]);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'part_number' => 'required|unique:items,part_number,' . $item->id,
            'definition' => 'required',
            'active' => 'required|boolean',
        ]);

        $item->update($request->all());
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        // Delete the associated stock entry
        Stock::where('item_id', $item->id)->delete();

        // Delete the item
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

}
