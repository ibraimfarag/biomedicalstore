@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard">
    <div class="dashboard-header">
        <h1>Welcome Back, {{ auth()->user()->name }}!</h1>
        <p>Here’s a quick overview of your system.</p>
    </div>

    <div class="row">

        <!-- Total Products -->
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-content">
                    <h3>Products</h3>
                    <p>{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="card-content">
                    <h3>Orders</h3>
                    <p>{{ $totalOrders }}</p>
                </div>
            </div>
        </div>

        <!-- Total Departments -->
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="card-content">
                    <h3>Departments</h3>
                    <p>{{ $totalDepartments }}</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row mt-5">
        
                <!-- Total Users -->
                <div class="col-md-2 ">
                    <div class="card text-center">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-content">
                            <h3>Users</h3>
                            <p>{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>
        
            <!-- Total Stocks with Transparent Table -->
<div class="col-md-4">
    <div class="card">
        <div class="card-content">
            <h3>Stock Overview</h3>
            <table class="table table-sm table-transparent">
                <thead>
                    <tr class="text-start">
                        <th>Item</th>
                        <th>Part No</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $stock)
                        <tr class="text-start">
                            <td>{{ $stock->item->definition ?? 'N/A' }}</td>
                            <td>{{ $stock->item->part_number ?? 'N/A' }}</td>
                            <td>{{ $stock->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($totalStocks > 10)
                <a href="{{ route('stocks.index') }}" class="btn btn-primary mt-3">View All</a>
            @endif
        </div>
    </div>
</div>



    </div>


</div>

@endsection
