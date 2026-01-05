@extends('layouts.app')

@section('title', 'Customers')

@section('page-title', 'Customers')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Customers</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalCustomers ?? 0 }}</h3>
                            <p>Total Customers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $activeCustomers ?? 0 }}</h3>
                            <p>Active Customers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $newCustomers ?? 0 }}</h3>
                            <p>New This Month</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $verifiedCustomers ?? 0 }}</h3>
                            <p>Verified Email</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Actions -->
            <form method="GET" action="{{ route('customers.index') }}" class="row g-2 mb-3 justify-content-end">
                <div class="col-md-3">
                    <select name="gender" class="form-control">
                        <option value="">-- All Gender --</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
                <div class="col-md-2">
                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger w-100" disabled>
                        <i class="fa-solid fa-trash-can"></i> Delete Selected
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('register') }}" class="btn btn-success w-100">+ New Customer</a>
                </div>
            </form>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer List</h3>
                </div>
                <div class="card-body">
                    <form id="bulkDeleteForm" action="{{ route('customers.bulk-delete') }}" method="POST">
                        @csrf
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center">Customer Code</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($customers as $customer)
                                    <tr data-username="{{ $customer->username ?? '-' }}"
                                        data-address="{{ $customer->address ?? '-' }}"
                                        data-birth-date="{{ $customer->date_of_birth ? date('M d, Y', strtotime($customer->date_of_birth)) : '-' }}"
                                        data-joined="{{ $customer->created_at ? date('M d, Y', strtotime($customer->created_at)) : '-' }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="row-checkbox" name="ids[]"
                                                value="{{ $customer->id }}">
                                        </td>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $customer->customer_code }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($customer->profile_image)
                                                    <img src="{{ asset('storage/' . $customer->profile_image) }}"
                                                        alt="{{ $customer->first_name }}" class="rounded-circle mr-2"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary text-white mr-2 d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($customer->first_name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $customer->first_name }}
                                                        {{ $customer->last_name }}</strong><br>
                                                    <small class="text-muted">{{ $customer->username }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $customer->email }}
                                            @if ($customer->email_verified_at)
                                                <i class="fas fa-check-circle text-success ml-1" title="Verified"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger ml-1" title="Not Verified"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $customer->phone ?? '-' }}</td>
                                        <td class="text-center">
                                            @if ($customer->gender == 'male')
                                                <span class="badge badge-primary">
                                                    <i class="fas fa-mars"></i> Male
                                                </span>
                                            @elseif($customer->gender == 'female')
                                                <span class="badge badge-pink">
                                                    <i class="fas fa-venus"></i> Female
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($customer->email_verified_at)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-sm btn-info details-control">
                                                <i class="fa-regular fa-folder-closed"></i>
                                            </button>
                                            <a href="{{ route('customers.edit', $customer) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No customers found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .badge-pink {
            background-color: #e83e8c;
            color: white;
        }

        .detail-row {
            background-color: #f8f9fa;
        }

        .detail-row td {
            padding: 15px !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            $("#example1").DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: [0, 8],
                    searchable: false,
                }],
                fnDrawCallback: function(oSettings) {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(1, {
                            order: "applied"
                        }).nodes()
                        .each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                },
            });

            // Row expansion for additional details
            $('#example1 tbody').on('click', '.details-control', function() {
                var tr = $(this).closest('tr');
                var username = tr.data('username');
                var address = tr.data('address');
                var birthDate = tr.data('birth-date');
                var joined = tr.data('joined');

                var detailRow = '<tr class="detail-row"><td colspan="9">' +
                    '<div class="row">' +
                    '<div class="col-md-3"><strong>Username:</strong> ' + username + '</div>' +
                    '<div class="col-md-3"><strong>Birth Date:</strong> ' + birthDate + '</div>' +
                    '<div class="col-md-3"><strong>Address:</strong> ' + address + '</div>' +
                    '<div class="col-md-3"><strong>Joined:</strong> ' + joined + '</div>' +
                    '</div></td></tr>';

                if (tr.next().hasClass('detail-row')) {
                    tr.next().remove();
                    $(this).find('i').removeClass('fa-folder-open').addClass('fa-folder-closed');
                } else {
                    tr.after(detailRow);
                    $(this).find('i').removeClass('fa-folder-closed').addClass('fa-folder-open');
                }
            });

            // Select all checkboxes
            $('#selectAll').on('click', function() {
                $('.row-checkbox').prop('checked', this.checked);
                updateBulkDeleteButton();
            });

            // Individual checkbox
            $('.row-checkbox').on('change', function() {
                updateBulkDeleteButton();
            });

            function updateBulkDeleteButton() {
                const checkedCount = $('.row-checkbox:checked').length;
                $('#bulkDeleteBtn').prop('disabled', checkedCount === 0);
            }

            // Bulk delete
            $('#bulkDeleteBtn').on('click', function() {
                const checkedCount = $('.row-checkbox:checked').length;
                if (confirm(`Are you sure you want to delete ${checkedCount} customer(s)?`)) {
                    $('#bulkDeleteForm').submit();
                }
            });

            // Delete confirmation
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this customer?')) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
