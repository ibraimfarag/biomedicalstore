<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Stock; // Import the Stock model

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        
        // Retrieve orders based on status or get all orders if no status is specified
        $orders = $status ? Order::where('status', $status)->get() : Order::all();
        
        // Get the count of orders for each status
        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'under_processing' => Order::where('status', 'under_processing')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
            'approved' => Order::where('status', 'approved')->count(),
            'done' => Order::where('status', 'done')->count(),
        ];
    
        if ($request->ajax()) {
            return view('orders.table', compact('orders'));
        }
    
        return view('orders.index', compact('orders', 'status', 'statusCounts'));
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $newStatus = $request->status;

        // Update the order status
        $order->update(['status' => $newStatus]);

        // If status is 'done' or 'approved', update stock
        if (in_array($newStatus, ['done', 'approved'])) {
            $leftInStock = $order->left_in_stock;

            // Fetch the stock related to the order
            $stock = Stock::where('item_id', $order->qty_id)->first();

            if ($stock) {
                
                // Update the stock quantity
                $stock->update(['quantity' => $leftInStock]);
            } else {
                // Handle the case where stock is not found, if necessary
                // You might want to create a new stock entry or log an error
            }
        }

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }
    
    public function exportOrders()
    {
        return Excel::download(new OrdersExport, 'orders_done.xlsx');
    }
}
