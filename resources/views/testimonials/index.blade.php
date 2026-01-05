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
                            <a href="{{ route('testimonials.create') }}" class="btn btn-primary btn-sm">
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
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $testimonial->display_order }}</td>
                                        <td>
                                            <a href="{{ route('testimonials.edit', $testimonial) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('testimonials.destroy', $testimonial) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this testimonial?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
        });
    </script>
@endpush
