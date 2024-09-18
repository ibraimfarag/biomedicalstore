@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Request Items</h2>
    <!-- Search Input -->
    <div class="form-group mb-4">
        <input type="text" id="search-input" class="form-control" placeholder="Search by Definition or Part Number">
    </div>
    
    <form action="{{ route('requests.store') }}" method="POST">
        @csrf

        <!-- Items container -->
        <div id="items-container" class="d-flex flex-wrap">
            @foreach ($items as $item)
                <div class="item-box text-center m-2 p-3"
                     data-item-id="{{ $item->id }}"
                     data-item-part-number="{{ $item->part_number }}"
                     data-item-definition="{{ $item->definition }}"
                     data-item-stock="{{ $item->stock }}">
                    <i class="fas fa-box fa-3x"></i>
                    <div class="mt-2"><strong>{{ $item->part_number }}</strong></div>
                    <div>{{ $item->definition }}</div>
                    @if ($item->stock <= 0)
                        <div class="sold-out-overlay">Sold Out</div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Hidden Modal -->
        <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="itemModalLabel">Item Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Part Number:</strong> <span id="modal-part-number"></span></p>
                        <p><strong>Definition:</strong> <span id="modal-definition"></span></p>
                        <p><strong>Current Stock:</strong> <span id="modal-stock"></span></p>
                        <div class="mb-3">
                            <label for="modal-quantity" class="form-label">Enter Quantity</label>
                            <input type="number" class="form-control" id="modal-quantity" min="1" value="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="add-item-button">Add to Request</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Items Table -->
        <div class="mt-4">
            <h4 class="table-title">Selected Items</h4>
            <table class="table table-striped table-bordered" id="selected-items-table">
                <thead>
                    <tr>
                        <th>Definition</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="selected-items-container">
                    <!-- Selected items will be injected here -->
                </tbody>
            </table>
        </div>

        <!-- Additional Fields -->

        <!-- Select Division -->
        <div class="form-group mb-4">
            <label for="division_id">Select Division</label>
            <select id="division_id" name="division_id" class="form-control">
                <option value="">-- Select Division --</option>
                @foreach($Division as $division)
                    <option value="{{ $division->name }}">{{ $division->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <div class="form-group mb-3">
                <label for="reason">Reason/Comments</label>
                <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="work_order_number">Work Order Number</label>
                <input type="text" class="form-control" id="work_order_number" name="work_order_number">
            </div>
        </div>

        <!-- Submit Button and Request Date at the Bottom -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
            <div class="form-group mb-0">
                <label for="request_date">Request Date</label>
                <input type="date" class="form-control" id="request_date" name="request_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit Request</button>
        </div>
    </form>
</div>
@endsection

@section('content-js')
<script>
    let selectedItems = [];

    document.addEventListener('DOMContentLoaded', function () {
        // Set today's date as the minimum selectable date for the request_date field
        const today = new Date().toISOString().split('T')[0];
    const requestDateInput = document.getElementById('request_date');
    requestDateInput.setAttribute('min', today);
    requestDateInput.value = today; // Set default date to today


        // Map stock data from the backend
        const stockData = @json($items->mapWithKeys(function($item) {
            return [$item->id => $item->stocks->sum('quantity')]; // Adjust according to your actual stock data
        }));

        // Handle item click to open the modal
        document.querySelectorAll('.item-box').forEach(item => {
            const itemId = item.getAttribute('data-item-id');
            const stock = stockData[itemId] || 0;

            if (stock <= 0) {
                item.classList.add('sold-out');
                item.querySelector('.sold-out-overlay').style.display = 'block';
                item.removeEventListener('click', openModal);
            } else {
                item.addEventListener('click', openModal);
            }
        });

        function openModal() {
            const itemId = this.getAttribute('data-item-id');
            const partNumber = this.getAttribute('data-item-part-number');
            const definition = this.getAttribute('data-item-definition');
            const stock = stockData[itemId] || 0;

            // Update modal with item details
            document.getElementById('modal-part-number').innerText = partNumber;
            document.getElementById('modal-definition').innerText = definition;
            document.getElementById('modal-stock').innerText = stock;
            document.getElementById('modal-quantity').value = 1;
            document.getElementById('modal-quantity').setAttribute('max', stock);

            // Store itemId in modal for adding to request
            document.getElementById('add-item-button').setAttribute('data-item-id', itemId);

            // Show modal
            $('#itemModal').modal('show');
        }

        // Handle adding item from modal to the request
        document.getElementById('add-item-button').addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');
            const quantity = parseInt(document.getElementById('modal-quantity').value);
            const stock = parseInt(document.getElementById('modal-quantity').getAttribute('max'));
            const partNumber = document.getElementById('modal-part-number').innerText;
            const definition = document.getElementById('modal-definition').innerText;

            if (quantity > stock) {
                alert(`Quantity cannot exceed the available stock of ${stock}.`);
                return;
            }

            // Check if item already exists in selectedItems array
            const existingItemIndex = selectedItems.findIndex(item => item.item_id === itemId);

            if (existingItemIndex !== -1) {
                // If the item exists, update the quantity with the new value
                selectedItems[existingItemIndex].quantity = quantity;

                // Update the corresponding row with the new quantity
                document.querySelector(`.selected-item-row[data-item-id="${itemId}"] .item-quantity`).innerText = `x ${quantity}`;
                document.querySelector(`input[name="items[${existingItemIndex}][quantity]"]`).value = quantity;
            } else {
                // Add selected item to the array
                selectedItems.push({
                    item_id: itemId,
                    part_number: partNumber,
                    definition: definition,
                    quantity: quantity
                });

                // Update the selected items table
                const selectedItemHTML = `
                    <tr class="selected-item-row" data-item-id="${itemId}">
                        <td>
                            <strong>${definition}</strong><br>
                            Part Number: ${partNumber}
                            <input type="hidden" name="items[${selectedItems.length - 1}][id]" value="${itemId}">
                            <input type="hidden" name="items[${selectedItems.length - 1}][quantity]" value="${quantity}">
                        </td>
                        <td class="item-quantity">x ${quantity}</td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm edit-item-button">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm remove-item-button">Remove</button>
                        </td>
                    </tr>
                `;
                document.getElementById('selected-items-container').innerHTML += selectedItemHTML;
            }

            // Hide modal
            $('#itemModal').modal('hide');

            // Add event listeners to remove and edit buttons
            document.querySelectorAll('.remove-item-button').forEach((btn) => {
                btn.addEventListener('click', function () {
                    this.closest('tr').remove();
                    selectedItems = selectedItems.filter(item => item.item_id !== itemId); // Remove from array
                });
            });

            document.querySelectorAll('.edit-item-button').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const selectedItemRow = this.closest('tr');
                    const itemId = selectedItemRow.getAttribute('data-item-id');
                    const existingItemIndex = selectedItems.findIndex(item => item.item_id === itemId);

                    if (existingItemIndex !== -1) {
                        // Pre-fill the modal with the current quantity
                        document.getElementById('modal-part-number').innerText = selectedItems[existingItemIndex].part_number;
                        document.getElementById('modal-definition').innerText = selectedItems[existingItemIndex].definition;
                        document.getElementById('modal-stock').innerText = ''; // You can add stock logic here
                        document.getElementById('modal-quantity').value = selectedItems[existingItemIndex].quantity;

                        // Store itemId in modal for updating the request
                        document.getElementById('add-item-button').setAttribute('data-item-id', itemId);

                        // Show modal
                        $('#itemModal').modal('show');
                    }
                });
            });
        });

        // Handle search functionality
        document.getElementById('search-input').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();

            document.querySelectorAll('.item-box').forEach(item => {
                const partNumber = item.getAttribute('data-item-part-number').toLowerCase();
                const definition = item.getAttribute('data-item-definition').toLowerCase();

                if (partNumber.includes(searchValue) || definition.includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
