<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Request;
use App\Models\RequestItem;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Division;


class RequestController extends Controller
{
    public function index()
    {
        $items = Item::with('stocks')->get(); // Fetch items with their related stocks
        $Division = Division::get(); // Fetch
        return view('requests.index', compact('items','Division'));
    }

    public function store(HttpRequest $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'request_date' => 'required|date'
        ]);

        $newRequest = Request::create([
            'user_id' => Auth::id(),
            'department_id' => $request->division_id,
            'request_date' => $request->request_date
        ]);

        foreach ($request->items as $item) {
            RequestItem::create([
                'request_id' => $newRequest->id,
                'item_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }
          // Debugging and creating Order records
    $ordersData = [];

    foreach ($request->items as $item) {
        $itemModel = Item::with('stocks')->find($item['id']);
        $stock = $itemModel->stocks->first(); 
        $leftInStock = $stock->quantity - $item['quantity'];
        // Collect data for each order
        $ordersData[] = [
            'qty_id' => $itemModel->id, // Add the qty_id field here

            'part_number' => $itemModel->part_number,
            'definition' => $itemModel->definition,
            'qty' => $item['quantity'],
            'date' => $request->request_date,
            'biomed_id' => Auth::id(), // Requester's user ID
            'department' => $request->division_id,
            'reason' => $request->input('reason', null),
            'work_order_number' => $request->input('work_order_number', null),
            'left_in_stock' => $leftInStock,
            'status' => 'pending'
        ];
    }

      // Output all collected order data
    //   dd($ordersData);

      // Create Order records (commented out for debugging)
      foreach ($ordersData as $orderData) {
          Order::create($orderData);
      }
    
        

        return redirect()->route('requests.index')->with('success', 'Request placed successfully.');
    }
}
