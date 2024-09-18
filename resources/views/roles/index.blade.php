@extends('layouts.master')

@section('title', 'Roles Management')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary font-weight-bold">Roles Management</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
        </div>

        <div class=" mb-4">
            <!-- Create Role Button -->
            <button type="button" class="btn btn-outline-primary btn-lg shadow-sm mr-3" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="fas fa-plus-circle"></i> Create Role
            </button>

            <!-- Assign Roles to Department Button -->
            <button type="button" class="btn btn-outline-secondary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#assignRolesModal">
                <i class="fas fa-building"></i> Assign Roles to Departments
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Roles List</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="align-middle">{{ $role->name }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-warning btn-sm mx-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-permissions="{{ $role->permissions->pluck('id') }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  <!-- Modal HTML for Create Role -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Role Name</label>
                        <input type="text" class="form-control" id="create-role-name" name="name" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="permissions">Assign Permissions</label>
                        <div id="create-permissions">
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="create-permission-{{ $permission->id }}">
                                    <label class="form-check-label" for="create-permission-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Role</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML for Edit Role -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="edit-name">Role Name</label>
                        <input type="text" class="form-control" id="edit-role-name" name="name" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit-permissions">Assign Permissions</label>
                        <div id="edit-permissions">
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="edit-permission-{{ $permission->id }}">
                                    <label class="form-check-label" for="edit-permission-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Role</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML for Assign Roles to Departments -->
<div class="modal fade" id="assignRolesModal" tabindex="-1" aria-labelledby="assignRolesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignRolesModalLabel">Assign Roles to Departments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('storeAssignments') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="department">Select Department</label>
                        <select class="form-control" id="department" name="department">
                            <option value="">Select a Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="roles">Select Roles</label>
                        <div id="roles">
                            <!-- Roles will be dynamically added here -->
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Assign Roles</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('content-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editRoleModal = document.getElementById('editRoleModal');
        editRoleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var roleId = button.getAttribute('data-id');
            var roleName = button.getAttribute('data-name');
            var rolePermissions = JSON.parse(button.getAttribute('data-permissions'));

            var form = document.getElementById('editRoleForm');
            form.action = '/roles/' + roleId; // Adjust the URL as necessary

            var nameInput = document.getElementById('edit-role-name');
            nameInput.value = roleName;

            var permissionsDiv = document.getElementById('edit-permissions');
            permissionsDiv.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                checkbox.checked = rolePermissions.includes(parseInt(checkbox.value));
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Assuming you want to load data for a default department or set up a way to select a department
        const defaultDepartmentId = document.getElementById('department').value; // Change this as needed
        
        updateRoles(defaultDepartmentId);
        
        // Add an event listener for changes to the department dropdown
        document.getElementById('department').addEventListener('change', function() {
            const departmentId = this.value;
            updateRoles(departmentId);
        });
    });

    function updateRoles(departmentId) {
        if (!departmentId) return;

        fetch(`/assign-to-department?department=${departmentId}`)
            .then(response => response.json())
            .then(data => {
                const rolesContainer = document.getElementById('roles');
                rolesContainer.innerHTML = '';

                data.roles.forEach(role => {
                    const checked = data.selectedRoles.includes(role.id) ? 'checked' : '';
                    rolesContainer.innerHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="${role.id}" id="role-${role.id}" ${checked}>
                            <label class="form-check-label" for="role-${role.id}">
                                ${role.name}
                            </label>
                        </div>
                    `;
                });
            })
            .catch(error => console.error('Error fetching roles:', error));
    }
</script>




@endsection
