@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Edit Item</h2>
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="part_number">Part Number</label>
            <input type="text" class="form-control" id="part_number" name="part_number" value="{{ $item->part_number }}" required>
        </div>
        <div class="form-group">
            <label for="definition">Definition</label>
            <input type="text" class="form-control" id="definition" name="definition" value="{{ $item->definition }}" required>
        </div>
        <div class="form-group">
            <label for="active">Active</label>
            <input type="checkbox" id="active" name="active" value="1" {{ $item->active ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
