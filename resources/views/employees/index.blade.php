@extends('layouts.app')

@section('title', 'Employees')

@section('page-title', 'Employees')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Employees</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-3 text-right">
                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger" disabled>
                        <i class="fa-solid fa-trash-can"></i> Delete Selected
                    </button>
                    <a href="{{ route('employees.create') }}" class="btn btn-success">+ New Employee</a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Employee List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="bulkDeleteForm" action="{{ route('employees.bulk-delete') }}" method="POST">
                            @csrf
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th class="text-center" width="5%">No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Position</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="180">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                    <tr data-hire-date="{{ $employee->hire_date ? date('m/d/Y', strtotime($employee->hire_date)) : '-' }}"
                                        data-salary="{{ $employee->salary ? '$' . number_format($employee->salary, 0, ',', ',') : '-' }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="row-checkbox" name="ids[]" value="{{ $employee->id }}">
                                        </td>
                                        <td class="text-center"></td>
                                        <td>
                                            <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>
                                        </td>
                                        <td>{{ $employee->position->position_name ?? 'N/A' }}</td>
                                        <td>{{ $employee->department->department_name ?? 'N/A' }}</td>
                                        <td>{{ $employee->email ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($employee->status == 'active')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-sm btn-info details-control">
                                                <i class="fa-regular fa-folder-closed"></i>
                                            </button>
                                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No employees found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
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
    
    <style>
        .employee-details {
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 3px solid #17a2b8;
        }
        .employee-details dl {
            margin-bottom: 0;
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 10px;
        }
        .employee-details dt {
            font-weight: 600;
            color: #495057;
        }
        .employee-details dd {
            margin-bottom: 0;
            color: #6c757d;
        }
    </style>
@endpush

@push('scripts')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            // Format function for row details
            function format(rowData) {
                return '<div class="employee-details">' +
                    '<dl>' +
                    '<dt>Hire Date</dt>' +
                    '<dd>' + rowData.hireDate + '</dd>' +
                    '<dt>Salary</dt>' +
                    '<dd>' + rowData.salary + '</dd>' +
                    '</dl>' +
                    '</div>';
            }

            var table = $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 1, 7],
                    "searchable": false
                }],
                "order": [
                    [2, 'asc']
                ],
                "fnDrawCallback": function(oSettings) {
                    // Auto numbering
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(1, {
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = startIndex + i + 1;
                    });
                }
            });

            // Add event listener for opening and closing details
            $('#example1 tbody').on('click', '.details-control', function(e) {
                e.preventDefault();
                var btn = $(this);
                var tr = btn.closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    btn.html('<i class="fa-regular fa-folder-closed"></i>');
                } else {
                    // Open this row
                    var rowData = {
                        hireDate: tr.data('hire-date'),
                        salary: tr.data('salary')
                    };
                    row.child(format(rowData)).show();
                    tr.addClass('shown');
                    btn.html('<i class="fa-regular fa-folder-open"></i>');
                }
            });
            
            // SweetAlert2 Delete Confirmation
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Checkbox functionality
            $('#selectAll').on('click', function() {
                $('.row-checkbox').prop('checked', this.checked);
                toggleBulkDeleteBtn();
            });

            $('.row-checkbox').on('change', function() {
                var allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#selectAll').prop('checked', allChecked);
                toggleBulkDeleteBtn();
            });

            function toggleBulkDeleteBtn() {
                var checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#bulkDeleteBtn').prop('disabled', false);
                } else {
                    $('#bulkDeleteBtn').prop('disabled', true);
                }
            }

            // Bulk delete confirmation
            $('#bulkDeleteBtn').on('click', function(e) {
                e.preventDefault();
                var checkedCount = $('.row-checkbox:checked').length;
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${checkedCount} employee(s)!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#bulkDeleteForm').submit();
                    }
                });
            });
        });
    </script>
@endpush
