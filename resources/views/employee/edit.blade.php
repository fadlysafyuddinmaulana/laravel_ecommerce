@extends('layouts.app')

@section('title', 'Edit Employee')

@section('page-title', 'Edit Employee')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Employee Information</h3>
        </div>
        <!-- form start -->
        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="form-group">
                    <label for="employee_code">Employee Code *</label>
                    <input type="text" name="employee_code" class="form-control" id="employee_code"
                           value="{{ old('employee_code', $employee->employee_code) }}" required>
                </div>

                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" name="first_name" class="form-control" id="first_name"
                           value="{{ old('first_name', $employee->first_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" id="last_name"
                           value="{{ old('last_name', $employee->last_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                           value="{{ old('email', $employee->email) }}">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone"
                           value="{{ old('phone', $employee->phone) }}">
                </div>

                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" name="username" class="form-control" id="username"
                           value="{{ old('username', $employee->username) }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="Leave empty to keep current password">
                    <small class="text-muted">Leave empty to keep current password. Minimum 8 characters if changing.</small>
                </div>

                <div class="form-group">
                    <label for="position">Position *</label>
                    <input type="text" name="position" class="form-control" id="position"
                           value="{{ old('position', $employee->position) }}" required>
                </div>

                <div class="form-group">
                    <label for="department">Department *</label>
                    <input type="text" name="department" class="form-control" id="department"
                           value="{{ old('department', $employee->department) }}" required>
                </div>

                <div class="form-group">
                    <label for="hire_date">Hire Date</label>
                    <input type="date" name="hire_date" class="form-control" id="hire_date"
                           value="{{ old('hire_date', $employee->hire_date) }}">
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Employee</button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
