@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Permissions</h2>
    
    <!-- Button to Open Create Permission Modal -->
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
        Add New Permission
    </button>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('permissions.index') }}" class="mb-4">
        <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="Search permissions..." value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>

    <!-- Permissions Table -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPermissionModal" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                            Edit
                        </button>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal HTML for Create Permission -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPermissionModalLabel">Create New Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Permission Name</label>
                        <input type="text" class="form-control" id="create-name" name="name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Permission</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML for Edit Permission -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPermissionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="edit-name">Permission Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Permission</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-js')
<script>
    // JavaScript to handle opening of the edit modal
    document.addEventListener('DOMContentLoaded', () => {
        const editPermissionModal = document.getElementById('editPermissionModal');
        
        editPermissionModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget; // Button that triggered the modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');

            const form = document.getElementById('editPermissionForm');
            form.action = `/permissions/${id}`; // Update form action with the correct route

            const input = document.getElementById('edit-name');
            input.value = name;
        });
    });
</script>
@endsection
