@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Items</h2>
    <a href="{{ route('items.create') }}" class="btn btn-primary">Add Item</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Part Number</th>
                <th>Definition</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->part_number }}</td>
                    <td>{{ $item->definition }}</td>
                    <td>{{ $item->active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
