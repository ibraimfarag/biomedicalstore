@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Create Item</h2>
    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="part_number">Part Number</label>
            <input type="text" class="form-control" id="part_number" name="part_number" required>
        </div>
        <div class="form-group">
            <label for="definition">Definition</label>
            <input type="text" class="form-control" id="definition" name="definition" required>
        </div>
        <div class="form-group">
            <label for="active">Active</label>
            <input type="checkbox" id="active" name="active" value="1">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
