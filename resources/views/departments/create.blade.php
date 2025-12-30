@extends('layouts.app')

@section('title', 'Create Department')

@section('page-title', 'Create Department')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Create Department</h1>

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
            <h3 class="card-title">Create New Department</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('departments.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" name="name" class="form-control" id="name"
                           value="{{ old('name') }}" placeholder="Enter department name" required>
                </div>

                <div class="form-group">
                    <label for="department_code">Department Code</label>
                    <input type="text" name="department_code" class="form-control" id="department_code"
                           value="{{ old('department_code') }}" placeholder="Enter department code (optional)">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="4" 
                              placeholder="Enter department description">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="manager_id">Manager</label>
                    <select name="manager_id" id="manager_id" class="form-control">
                        <option value="">-- Select Manager (Optional) --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('manager_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active Status</label>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create Department</button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: calc(2.25rem) !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem) !important;
    }
</style>
@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
    // Initialize Select2
    $('#manager_id').select2({
        theme: 'bootstrap4',
        placeholder: '-- Select Manager (Optional) --',
        allowClear: true
    });
});
</script>
@endpush
