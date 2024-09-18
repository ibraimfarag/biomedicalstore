<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Item;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('item')->get();
        $items = Item::all(); // Retrieve all items for use in modals
        return view('stocks.index', compact('stocks', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0',
        ]);

        // Check if a stock record for the given item already exists
        $stock = Stock::where('item_id', $request->item_id)->first();

        if ($stock) {
            // Update the existing stock record
            $stock->quantity = $request->quantity;
            $stock->save();
        } else {
            // Create a new stock record
            Stock::create($request->all());
        }

        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $stock->update($request->all());
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }
}
