@extends('layouts.app')

@section('title', 'Edit Position')

@section('page-title', 'Edit Position')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('positions.index') }}">Positions</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Position #{{ $position->id }}</h1>

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
            <h3 class="card-title">Edit Position</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('positions.update', $position) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="position_name">Position Name *</label>
                            <input type="text" name="position_name" class="form-control" id="position_name"
                                   value="{{ old('position_name', $position->position_name) }}" placeholder="Enter position name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="position_code">Position Code</label>
                            <input type="text" name="position_code" class="form-control" id="position_code"
                                   value="{{ old('position_code', $position->position_code) }}" placeholder="Enter position code (optional)">
                            <small class="form-text text-muted">Example: MGR001, SUP001, STF001</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="level">Level *</label>
                            <select name="level" id="level" class="form-control" required>
                                <option value="">-- Select Level --</option>
                                <option value="1" {{ old('level', $position->level) == 1 ? 'selected' : '' }}>1 - Director/Executive</option>
                                <option value="2" {{ old('level', $position->level) == 2 ? 'selected' : '' }}>2 - Manager</option>
                                <option value="3" {{ old('level', $position->level) == 3 ? 'selected' : '' }}>3 - Supervisor</option>
                                <option value="4" {{ old('level', $position->level) == 4 ? 'selected' : '' }}>4 - Staff</option>
                                <option value="5" {{ old('level', $position->level) == 5 ? 'selected' : '' }}>5 - Trainee/Intern</option>
                            </select>
                            <small class="form-text text-muted">Hierarchy level: 1 = Highest, 5 = Lowest</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" id="department_id" class="form-control">
                                <option value="">-- Select Department (Optional) --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $position->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="4" 
                              placeholder="Enter position description, responsibilities, and requirements">{{ old('description', $position->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" {{ old('status', $position->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $position->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Position</button>
                <a href="{{ route('positions.index') }}" class="btn btn-secondary">Cancel</a>
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
    $('#level').select2({
        theme: 'bootstrap4',
        placeholder: '-- Select Level --',
        minimumResultsForSearch: -1
    });
    
    $('#department_id').select2({
        theme: 'bootstrap4',
        placeholder: '-- Select Department (Optional) --',
        allowClear: true
    });
    
    $('#status').select2({
        theme: 'bootstrap4',
        minimumResultsForSearch: -1
    });
});
</script>
@endpush
