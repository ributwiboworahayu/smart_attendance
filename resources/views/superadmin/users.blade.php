@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">

                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ __('Admin List') }}
                                </h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <a href="{{ route('users.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus me-2"></i>
                                    {{ __('Add Admin') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="users-table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Sub Branch</th>
                                <th scope="col">Act</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function () {
            $('#users-table').DataTable({
                // processing: true,
                // serverSide: true,
                language: {
                    url: '{{ asset('assets/lang/id/dataTables.json') }}'
                },
                // ajax: {
                {{--    url: '{{ route('admin.users.datatables') }}',--}}
                //     data: function (d) {
                //         d.order[0].column--
                //     }
                // },
                // columnns: [
                //     {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                //     {data: 'first_name', name: 'first_name'},
                //     {data: 'last_name', name: 'last_name'},
                //     {data: 'action', name: 'action', orderable: false, searchable: false}
                // ]
            })
        })
    </script>
@endpush
