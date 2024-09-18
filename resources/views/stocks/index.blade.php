@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Stocks</h2>
    {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">Add Stock</button> --}}
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->item->part_number }} - {{ $stock->item->definition }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editStockModal" data-stock-id="{{ $stock->id }}" data-item-id="{{ $stock->item_id }}" data-quantity="{{ $stock->quantity }}">Edit</button>
                        {{-- <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStockModal" data-stock-id="{{ $stock->id }}">Delete</button> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- 
<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">Add Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addStockForm" action="{{ route('stocks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal-item-id" class="form-label">Item</label>
                        <select class="form-select" id="modal-item-id" name="item_id" required>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->part_number }} - {{ $item->definition }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modal-quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="modal-quantity" name="quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Stock</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<!-- Edit Stock Modal -->
<div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel">Edit Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStockForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-modal-item-id" class="form-label">Item</label>
                        <select class="form-select" id="edit-modal-item-id" name="item_id" required>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->part_number }} - {{ $item->definition }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-modal-quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="edit-modal-quantity" name="quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Stock Modal -->
<div class="modal fade" id="deleteStockModal" tabindex="-1" aria-labelledby="deleteStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStockModalLabel">Delete Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this stock?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteStockForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle the Edit Stock Modal
        var editStockModal = new bootstrap.Modal(document.getElementById('editStockModal'));
        document.querySelectorAll('button[data-bs-target="#editStockModal"]').forEach(button => {
            button.addEventListener('click', function () {
                var stockId = this.getAttribute('data-stock-id');
                var itemId = this.getAttribute('data-item-id');
                var quantity = this.getAttribute('data-quantity');

                // Update form action
                var editStockForm = document.getElementById('editStockForm');
                editStockForm.action = `/stocks/${stockId}`;

                // Populate form fields
                document.getElementById('edit-modal-item-id').value = itemId;
                document.getElementById('edit-modal-quantity').value = quantity;

                editStockModal.show();
            });
        });

        // Handle the Delete Stock Modal
        var deleteStockModal = new bootstrap.Modal(document.getElementById('deleteStockModal'));
        document.querySelectorAll('button[data-bs-target="#deleteStockModal"]').forEach(button => {
            button.addEventListener('click', function () {
                var stockId = this.getAttribute('data-stock-id');

                // Update form action
                var deleteStockForm = document.getElementById('deleteStockForm');
                deleteStockForm.action = `/stocks/${stockId}`;

                deleteStockModal.show();
            });
        });
    });
</script>
@endsection
