@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Departments</h2>
    <!-- Create Department Button (Triggers Modal) -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
        Create Department
    </button>

    <!-- Departments Table -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>
                        <!-- Edit Button (Triggers Modal) -->
                        <button class="btn btn-warning" onclick="openEditModal({{ $department->id }}, '{{ $department->name }}')">Edit</button>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST" style="display:inline;">
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

<!-- Modal for Creating Department -->
<div class="modal fade" id="createDepartmentModal" tabindex="-1" aria-labelledby="createDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDepartmentModalLabel">Create Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createDepartmentForm" action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Department Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Department -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDepartmentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="editName">Department Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-js')
<script>
    // Function to open the Edit Modal and fill it with the current department data
    function openEditModal(id, name) {
        const modal = new bootstrap.Modal(document.getElementById('editDepartmentModal'), {});
        
        // Set the form action dynamically based on the department ID
        const editForm = document.getElementById('editDepartmentForm');
        editForm.action = `/departments/${id}`;

        // Set the current department name in the input field
        document.getElementById('editName').value = name;

        // Show the modal
        modal.show();
    }
</script>
@endsection
