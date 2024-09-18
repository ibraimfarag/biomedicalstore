@extends('layouts.master')

@section('title', 'Edit Profile')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
        </div>
        <!-- Add other profile fields as needed -->
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
