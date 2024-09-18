<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;
use App\Models\Order;
use App\Models\Department;
use App\Models\User;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the counts from your respective models
        $totalProducts = item::count();
        $totalOrders = Order::count();
        $totalDepartments = Department::count();
        $totalUsers = User::count();
        $totalStocks = Stock::count(); // Assuming you have a Stock model
        $stocks = Stock::with('item')->take(10)->get();
        
        // Pass the data to the view
        return view('dashboard.index', compact(
            'totalProducts',
            'totalOrders',
            'totalDepartments',
            'totalUsers',
            'totalStocks',
            'stocks'
        ));
    }
}
