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
        <form method="POST" action="{{ route('employees.update', $employee) }}" enctype="multipart/form-data">
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
                    <input type="tel" name="phone" class="form-control" id="phone"
                           value="{{ old('phone', $employee->phone) }}" placeholder="Enter phone number">
                    <input type="hidden" name="phone_country" id="phone_country">
                    <small class="text-muted">International format with country code</small>
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
                    <label for="profile_image">Profile Image</label>
                    @if($employee->profile_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="Current Profile Image" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                            <p class="text-muted small">Current profile image</p>
                        </div>
                    @endif
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="profile_image" class="custom-file-input" id="profile_image" accept="image/*">
                            <label class="custom-file-label" for="profile_image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                    <small class="text-muted">Select new profile image (jpg, png, jpeg, webp - max 2MB) - Leave empty to keep current image</small>
                </div>

                <div class="form-group">
                    <label for="position_code">Position *</label>
                    <select name="position_code" id="position_code" class="form-control">
                        <option value="">-- Select Position --</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->position_code }}" {{ old('position_code', $employee->position) == $position->position_code ? 'selected' : '' }}>
                                {{ $position->position_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="department_code">Department *</label>
                    <select name="department_code" id="department_code" class="form-control">
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->department_code }}" {{ old('department_code', $employee->department) == $department->department_code ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="hire_date">Hire Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" name="hire_date" class="form-control" id="hire_date"
                               value="{{ old('hire_date', $employee->hire_date) }}"
                               data-inputmask-alias="datetime"
                               data-inputmask-inputformat="yyyy-mm-dd"
                               data-mask
                               placeholder="yyyy-mm-dd">
                    </div>
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

@push('styles')
<!-- intl-tel-input -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.11/build/css/intlTelInput.css">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Custom styles for intl-tel-input -->
<style>
    .iti {
        width: 100%;
    }
    .iti__flag-container {
        z-index: 2;
    }
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
<!-- intl-tel-input -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.11/build/js/intlTelInput.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('assets/AdminLTE-3.2.0/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/AdminLTE-3.2.0/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/AdminLTE-3.2.0/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
$(function () {
    // Initialize intl-tel-input
    const phoneInput = document.querySelector("#phone");
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "id",
        preferredCountries: ["id", "us", "gb", "sg", "my"],
        separateDialCode: true,
        autoPlaceholder: "polite",
        formatOnDisplay: true,
        nationalMode: false,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.11/build/js/utils.js"
    });

    // Save country code on country change
    phoneInput.addEventListener('countrychange', function() {
        const countryData = iti.getSelectedCountryData();
        document.getElementById('phone_country').value = countryData.iso2;
    });

    // Form validation on submit
    $('form').on('submit', function(e) {
        if (phoneInput.value.trim()) {
            if (!iti.isValidNumber()) {
                e.preventDefault();
                alert('Please enter a valid phone number for the selected country');
                phoneInput.focus();
                return false;
            }
            // Set full international number
            phoneInput.value = iti.getNumber();
        }
    });
    
    // Initialize Select2
    $('#position_code').select2({
        theme: 'bootstrap4',
        placeholder: '-- Select Position --',
        allowClear: true
    });
    
    $('#department_code').select2({
        theme: 'bootstrap4',
        placeholder: '-- Select Department --',
        allowClear: true
    });
    
    $('#status').select2({
        theme: 'bootstrap4',
        minimumResultsForSearch: -1
    });
    
    // Initialize InputMask for date
    $('[data-mask]').inputmask();
    
    bsCustomFileInput.init();
});
</script>
@endpush
