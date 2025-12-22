@extends('layouts.app')

@section('title', 'Employees')

@section('page-title', 'Employees')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Employees</li>
@endsection

@section('content')
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="row">
            <div class="col-12">
                <div class="mb-3 text-right">
                    <a href="{{ route('employees.create') }}" class="btn btn-success">+ New Employee</a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Employee List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
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
                                        <td class="text-center"></td>
                                        <td>
                                            <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>
                                        </td>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->department }}</td>
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
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this employee?')"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No employees found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
            background-color: #f8f9fa !important;
            color: #212529 !important;
            padding: 20px !important;
            border-radius: 0 !important;
        }
        
        .employee-details dl {
            margin-bottom: 0 !important;
        }
        
        .employee-details dt {
            font-weight: 600 !important;
            color: #212529 !important;
            margin-bottom: 5px !important;
            width: 120px !important;
            float: left !important;
            clear: left !important;
        }
        
        .employee-details dd {
            margin-bottom: 10px !important;
            color: #212529 !important;
            margin-left: 130px !important;
        }
        
        table.dataTable tbody tr.child .employee-details,
        table.dataTable tbody tr.child .employee-details *,
        table.dataTable tbody tr.child .employee-details dt,
        table.dataTable tbody tr.child .employee-details dd {
            color: #212529 !important;
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
                    '<dt>Start date</dt>' +
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
                    "targets": [0, 6],
                    "searchable": false
                }],
                "order": [
                    [1, 'asc']
                ],
                "fnDrawCallback": function(oSettings) {
                    // Auto numbering
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(0, {
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
        });
    </script>
@endpush
