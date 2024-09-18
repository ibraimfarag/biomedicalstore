@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Orders</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Status Filters Buttons -->
    <div class="mb-4">
        <button class="btn filter-button" data-status="">
            All
        </button>
        @foreach ($statusCounts as $key => $count)
            <button class="btn  filter-button" data-status="{{ $key }}">
                {{ ucfirst($key) }} ({{ $count }})
            </button>
        @endforeach
    </div>

    <div id="orders-table">
        @include('orders.table', ['orders' => $orders])
    </div>
</div>
@endsection

@section('content-js')
<script>
    $(document).ready(function() {
        $('.filter-button').on('click', function() {
            var status = $(this).data('status');

            $.ajax({
                url: '{{ route('orders.index') }}',
                type: 'GET',
                data: { status: status },
                success: function(response) {
                    $('#orders-table').html(response);
                }
            });
        });
    });
</script>
@endsection
