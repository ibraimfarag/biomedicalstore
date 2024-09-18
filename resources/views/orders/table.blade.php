<!-- resources/views/orders/table.blade.php -->

<table class="table table-bordered">
    <thead>
        <tr>
            <th>PART NUMBER</th>
            <th>DEFINITION</th>
            <th>QTY</th>
            <th>DATE</th>
            <th>BIOMED (Requester)</th>
            <th>DEPARTMENT</th>
            <th>Reason</th>
            <th>Work Order Number</th>
            <th>Left in Stock</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->part_number }}</td>
                <td>{{ $order->definition }}</td>
                <td>{{ $order->qty }}</td>
                <td>{{ \Carbon\Carbon::parse($order->date)->format('Y-m-d') }}</td>
                <td>{{ $order->biomed->name }}</td>
                <td>{{ $order->department }}</td>
                <td>{{ $order->reason }}</td>
                <td>{{ $order->work_order_number }}</td>
                <td>{{ $order->left_in_stock }}</td>
                <td>
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control" required>
                            <option value="" disabled>Select status</option>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_processing" {{ $order->status == 'under_processing' ? 'selected' : '' }}>Under Processing</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
