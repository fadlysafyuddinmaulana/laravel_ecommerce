@extends('layouts.app')

@section('title', 'Page Contents (CMS)')

@section('page-title', 'Manage Page Contents')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Page Contents</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Page Contents</h3>
                        <div class="card-tools">
                            <a href="{{ route('page-contents.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Page Content
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

                        <table id="page-contents-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Page Name</th>
                                    <th>Section Key</th>
                                    <th>Content Type</th>
                                    <th>Status</th>
                                    <th>Display Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pageContents as $pageContent)
                                    <tr>
                                        <td></td>
                                        <td>{{ $pageContent->page_name }}</td>
                                        <td>{{ $pageContent->section_key }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $pageContent->content_type }}</span>
                                        </td>
                                        <td>
                                            @if ($pageContent->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $pageContent->display_order }}</td>
                                        <td>
                                            <a href="{{ route('page-contents.edit', $pageContent) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('page-contents.destroy', $pageContent) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this page content?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No page contents found.</td>
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
            var table = $("#page-contents-table").DataTable({
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
