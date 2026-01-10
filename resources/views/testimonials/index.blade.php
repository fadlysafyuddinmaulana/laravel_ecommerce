@extends('layouts.app')

@section('title', 'Testimonials')

@section('page-title', 'Manage Testimonials')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Testimonials</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Testimonials</h3>
                        <div class="card-tools">
                            <a href="{{ route('testimonials.create') }}" class="btn btn-filter-success">
                                <i class="fas fa-plus"></i> Add Testimonial
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <table id="testimonials-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Display Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($testimonials as $testimonial)
                                    <tr>
                                        <td></td>
                                        <td>{{ $testimonial->name }}</td>
                                        <td>{{ $testimonial->position }}</td>
                                        <td>{{ $testimonial->company ?? '-' }}</td>
                                        <td>
                                            @if ($testimonial->is_active)
                                                <span class="badge badge-success">
                                                    <i class="fa fa-eye"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fa fa-eye-slash"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $testimonial->display_order }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                                                <form action="{{ route('testimonials.toggle-active', $testimonial) }}"
                                                    method="POST" class="toggle-active-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button"
                                                        class="btn btn-figma-action {{ $testimonial->is_active ? 'text-warning' : 'text-success' }} btn-toggle-active"
                                                        title="{{ $testimonial->is_active ? 'Deactivate testimonial' : 'Activate testimonial' }}">
                                                        <i
                                                            class="fa {{ $testimonial->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('testimonials.edit', $testimonial) }}"
                                                    class="btn btn-figma-action" title="Edit Testimonial">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('testimonials.destroy', $testimonial) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-figma-action text-danger btn-delete"
                                                        title="Delete Testimonial">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No testimonials found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Figma Filter/Header Buttons */
        .btn-filter-success {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
            padding: 10px 20px;
            border-radius: 6px;
            border: 1px solid;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
            background: #10B981;
            border-color: #10B981;
            color: #FFFFFF;
        }

        .btn-filter-success:hover:not(:disabled) {
            background: #059669;
            border-color: #059669;
            color: #FFFFFF;
            box-shadow: 0px 2px 6px rgba(16, 185, 129, 0.25);
        }

        .btn-filter-success:active:not(:disabled) {
            background: #047857;
            border-color: #047857;
        }

        /* Figma Action Buttons */
        .btn-figma-action {
            background: #FDFDFD !important;
            border: 1px solid #DCDCDC !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
            color: #292929 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
            line-height: 20px;
        }

        .btn-figma-action:hover {
            background: #F5F5F5 !important;
            border-color: #B8B8B8 !important;
            box-shadow: 0px 2px 4px rgba(36, 36, 36, 0.08);
            color: #292929 !important;
        }

        .btn-figma-action:focus,
        .btn-figma-action:active {
            box-shadow: 0px 0px 0px 3px rgba(82, 82, 82, 0.1) !important;
            outline: none !important;
        }

        .btn-figma-action.text-danger {
            color: #DC2626 !important;
        }

        .btn-figma-action.text-danger:hover {
            background: #FEF2F2 !important;
            color: #DC2626 !important;
        }

        .btn-figma-action.text-warning {
            color: #F59E0B !important;
        }

        .btn-figma-action.text-warning:hover {
            background: #FFFBEB !important;
            color: #F59E0B !important;
        }

        .btn-figma-action.text-success {
            color: #10B981 !important;
        }

        .btn-figma-action.text-success:hover {
            background: #F0FDF4 !important;
            color: #10B981 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#testimonials-table").DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: [0, 6],
                    searchable: false,
                }],
                fnDrawCallback: function(oSettings) {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(0, {
                            order: "applied"
                        })
                        .nodes()
                        .each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                }
            });

            // Toggle Active/Inactive Confirmation
            $('.btn-toggle-active').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                var form = btn.closest('form');
                var isActive = btn.hasClass('btn-warning'); // warning = currently active

                Swal.fire({
                    title: isActive ? 'Deactivate this testimonial?' : 'Activate this testimonial?',
                    text: isActive ?
                        "Testimonial will be hidden from frontend" :
                        "Testimonial will be visible on frontend",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: isActive ? '#ffc107' : '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isActive ? 'Yes, deactivate it!' : 'Yes, activate it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Delete Confirmation
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
        });
    </script>
@endpush
