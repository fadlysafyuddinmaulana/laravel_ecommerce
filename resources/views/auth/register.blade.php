@extends('auth.layouts.portal')

@section('title', 'Portal E-Commerce')

@section('content')
    <div class="register-box" style="width: 70%;">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="h1"><b>Admin</b>LTE</h1>
            </div>
            <div class="card-body ">
                <p class="login-box-msg">Register a new membership</p>
                <form id="registerForm" action="{{ route('auth.register.post') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="step1">
                        <div class="row mb-3">
                            <div class="col-6">
                                <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                    required autofocus>
                            </div>
                            <div class="col-6">
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <select name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="text" name="phone" class="form-control" placeholder="Phone"
                                    maxlength="20">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Retype password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="nextStep">Next</button>
                        </div>
                    </div>
                    <div id="step2" style="display:none;">
                        <div class="form-group mb-3">
                            <div class="custom-file">
                                <input type="file" name="profile_image" class="custom-file-input" id="profileImageInput"
                                    accept="image/*">
                                <label class="custom-file-label" for="profileImageInput">Choose profile image</label>
                            </div>
                            <small class="form-text text-muted">jpg, png, jpeg, webp - max 2MB</small>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <input type="date" name="date_of_birth" class="form-control" placeholder="Date of Birth">
                            </div>
                            <div class="col-6">
                                <input type="text" name="address" class="form-control" placeholder="Address">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <input type="text" name="city" class="form-control" placeholder="City">
                            </div>
                            <div class="col-4">
                                <input type="text" name="state" class="form-control" placeholder="State">
                            </div>
                            <div class="col-4">
                                <input type="text" name="zip_code" class="form-control" placeholder="Zip Code">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree" />
                                    <label for="agreeTerms"> I agree to the <a href="#">terms</a> </label>
                                </div>
                            </div>
                            <div class="col-4 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" id="prevStep">Previous</button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block w-100">Register</button>
                            </div>
                        </div>
                    </div>
                </form>

                <a href="{{ route('auth.login') }}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.register-box -->
@endsection


@push('scripts')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            bsCustomFileInput.init();
            // Multi-step logic
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            document.getElementById('nextStep').onclick = function() {
                step1.style.display = 'none';
                step2.style.display = '';
            };
            document.getElementById('prevStep').onclick = function() {
                step2.style.display = 'none';
                step1.style.display = '';
            };
        });
    </script>
@endpush
