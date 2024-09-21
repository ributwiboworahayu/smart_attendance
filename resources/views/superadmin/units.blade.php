@extends('layouts.app')

@section('title', 'Units')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">

                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ __('Units') }}
                                </h2>
                            </div>
                            <div class="col-auto ms-auto">
                                <a href="{{ route('superadmin.units.store') }}" class="btn btn-primary" id="add-unit">
                                    <i class="bi bi-plus me-2"></i>
                                    {{ __('Add Unit') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any() || session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @if(session('error'))
                                        <li>{{ session('error') }}</li>
                                    @endif
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </ul>
                            </div>
                        @endif

                        <table class="table" id="units-table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Unit ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="unitsModal" tabindex="-1" aria-labelledby="unitsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="unitsModalLabel">Edit Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="editModalBody">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Unit</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function () {
            const dateFormater = new Intl.DateTimeFormat('id-ID', {
                weekday: 'short',  // Untuk menampilkan nama hari (Sen, Sel, dst.)
                year: 'numeric',    // Untuk menampilkan tahun
                month: 'short',     // Untuk menampilkan bulan dalam format singkat (Jan, Feb, dst.)
                day: 'numeric',     // Untuk menampilkan tanggal
                hour: '2-digit',    // Untuk menampilkan jam dalam dua digit
                minute: '2-digit',  // Untuk menampilkan menit dalam dua digit
                hour12: false       // Menentukan format 24 jam
            });
            const unitsTable = $('#units-table')
            unitsTable.DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: '{{ asset('assets/lang/id/dataTables.json') }}'
                },
                order: [[1, 'asc']],
                ajax: {
                    url: '{{ route('superadmin.units.datatables') }}',
                    data: function (d) {
                        d.order[0].column--
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {
                        data: 'created_at', name: 'created_at', render: function (data) {
                            return dateFormater.format(new Date(data))
                        }
                    },
                    {
                        data: 'updated_at', name: 'updated_at', render: function (data) {
                            return dateFormater.format(new Date(data))
                        }
                    },
                    {
                        data: 'actions', name: 'actions', orderable: false, searchable: false,
                        render: function (data) {
                            let buttons = ''
                            $.each(data, function (key, value) {
                                buttons += `<a href="${value.route}" class="btn btn-sm mx-sm-1 ${value.class}"><i class="${value.icon}"></i></a> `
                            })
                            return buttons
                        }
                    }
                ],
                initComplete: function () {
                    const urlParams = new URLSearchParams(window.location.search)
                    let page = urlParams.get('page')
                    const addUnit = $('#add-unit')
                    if (page) {
                        unitsTable.DataTable().page(page - 1).draw('page')
                    }
                    // set add + page
                    const pageInfo = unitsTable.DataTable().page.info()
                    page = pageInfo.page + 1

                    urlParams.set('page', page)
                    const urlParamsString = urlParams.toString()
                    addUnit.attr('href', `{{ route('superadmin.units.store') }}?${urlParamsString}`)
                    // set url
                    window.history.replaceState(null, null, `?${urlParamsString}`)
                }

            })

            // on click first, previous, next, and last page
            // when clicked, change the url
            unitsTable.on('page.dt', function () {
                // get current page
                const info = unitsTable.DataTable().page.info()
                const page = info.page + 1
                const urlParams = new URLSearchParams(window.location.search)
                urlParams.set('page', page)
                const urlParamsString = urlParams.toString()

                // set url
                window.history.replaceState(null, null, `?${urlParamsString}`)

                // set add + page
                $('#add-unit').attr('href', `{{ route('superadmin.units.store') }}?${urlParamsString}`)
            })


            // Add Unit
            $('#add-unit').on('click', function (e) {
                e.preventDefault()
                $('#unitsModal form').attr('action', $(this).attr('href'))
                $('#unitsModalLabel').text('Tambah Unit')
                $('#unitsModal').modal('show')
            })

        })
    </script>
@endpush
