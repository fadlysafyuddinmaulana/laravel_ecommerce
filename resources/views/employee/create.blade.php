@extends('layouts.app')

@section('title', 'Create Employee')

@section('page-title', 'Create Employee')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
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
            <h3 class="card-title">Create New Employee</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('employees.store') }}">
            @csrf
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Employee Code will be auto-generated: <strong>{{ $nextEmployeeCode }}</strong>
                </div>

                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" name="first_name" class="form-control" id="first_name"
                           value="{{ old('first_name') }}" placeholder="Enter first name" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" id="last_name"
                           value="{{ old('last_name') }}" placeholder="Enter last name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                           value="{{ old('email') }}" placeholder="Enter email address">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone"
                           value="{{ old('phone') }}" placeholder="Enter phone number">
                </div>

                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" name="username" class="form-control" id="username"
                           value="{{ old('username') }}" placeholder="Enter username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="Enter password" required>
                    <small class="text-muted">Minimum 8 characters</small>
                </div>

                <div class="form-group">
                    <label for="position">Position *</label>
                    <input type="text" name="position" class="form-control" id="position"
                           value="{{ old('position') }}" placeholder="Enter position" required>
                </div>

                <div class="form-group">
                    <label for="department">Department *</label>
                    <input type="text" name="department" class="form-control" id="department"
                           value="{{ old('department') }}" placeholder="Enter department" required>
                </div>

                <div class="form-group">
                    <label for="hire_date">Hire Date</label>
                    <input type="date" name="hire_date" class="form-control" id="hire_date"
                           value="{{ old('hire_date') }}">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create Employee</button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- jQuery -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
@endpush
