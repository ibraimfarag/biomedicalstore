@extends('layouts.master')


@section('content')
<div class="container">
    <h1>Division Requester</h1>

    <!-- Display success messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create a new division form -->
    <form action="{{ route('divisions.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Division Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Add Division</button>
    </form>

    <!-- Display the list of divisions -->
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Division Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($divisions as $division)
                <tr>
                    <td>{{ $division->name }}</td>
                    <td>
                        <!-- Form to delete the division -->
                        <form action="{{ route('divisions.delete', $division->id) }}" method="POST">
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
