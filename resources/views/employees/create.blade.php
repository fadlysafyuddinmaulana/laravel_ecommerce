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
        <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
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
                    <input type="tel" name="phone" class="form-control" id="phone"
                           value="{{ old('phone') }}" placeholder="Enter phone number">
                    <input type="hidden" name="phone_country" id="phone_country">
                    <small class="text-muted">International format with country code</small>
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
                    <label for="profile_image">Profile Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="profile_image" class="custom-file-input" id="profile_image" accept="image/*">
                            <label class="custom-file-label" for="profile_image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                    <small class="text-muted">Select profile image (jpg, png, jpeg, webp - max 2MB)</small>
                </div>

                <div class="form-group">
                    <label for="position_code">Position *</label>
                    <select name="position_code" id="position_code" class="form-control">
                        <option value="">-- Select Position --</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_code') == $position->id ? 'selected' : '' }}>
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
                            <option value="{{ $department->id }}" {{ old('department_code') == $department->id ? 'selected' : '' }}>
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
                               value="{{ old('hire_date') }}" 
                               data-inputmask-alias="datetime" 
                               data-inputmask-inputformat="yyyy-mm-dd" 
                               data-mask
                               placeholder="yyyy-mm-dd">
                    </div>
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
    <!-- Page specific script -->
    <script>
        $(function () {
            // Initialize intl-tel-input
            const phoneInput = document.querySelector("#phone");
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "id", // Indonesia sebagai default
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
                minimumResultsForSearch: -1 // Disable search for small lists
            });
            
            // Initialize InputMask for date
            $('[data-mask]').inputmask();
            
            bsCustomFileInput.init();
        });
    </script>
@endpush
