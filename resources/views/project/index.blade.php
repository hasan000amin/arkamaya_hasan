@extends('layouts.app')
@push('styles')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Project</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <form id="search-form">
                        <div class="card-header d-flex justify-content-center align-items-center">
                            <div class="col-md-1">Filter</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Project Name</label>
                                    <input type="text" class="form-control" id="search">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="client">Client</label>
                                    <select name="client" id="client" class="form-control">
                                        <option selected value="">All Client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->client_name }}">{{ $client->client_name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="client_id-error" class="invalid-feedback"></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filterByStatus">Status</label>
                                    <select name="filterByStatus" id="status" class="form-control">
                                        <option selected value="">All Status</option>
                                        <option value="OPEN">OPEN</option>
                                        <option value="DOING">DOING</option>
                                        <option value="DONE">DONE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col mt-3">
                                <button class="btn btn-success btnSearch">Search</button>
                                <button class="btn btn-warning btnClear">Clear</button>
                            </div>
                        </div>
                    </form>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-primary btn-sm btn-block" id="btnCreate">New</button>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-danger btn-sm btn-block" id="delete-selected">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" id="select_all"></th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Project Name</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Project Start</th>
                                        <th scope="col">Project End</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal tambah --}}
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="myForm">
                            <input type="hidden" name="project_id" id="project_id">
                            <div class="form-group">
                                <label for="project_name">Project Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="project_name" name="project_name">
                                <small id="project_name-error" class="invalid-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label for="client_id">Client<span class="text-danger">*</span></label>
                                <select name="client_id" id="client_id" class="form-control">
                                    <option selected disabled>Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->client_id }}">{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                                <small id="client_id-error" class="invalid-feedback"></small>
                            </div>
                            <div class="form-group">
                                <label for="project_start">Project Start</label>
                                <input type="date" class="form-control" id="project_start" name="project_start">
                            </div>
                            <div class="form-group">
                                <label for="project_end">Project End</label>
                                <input type="date" class="form-control" id="project_end" name="project_end">
                            </div>
                            <div class="form-group">
                                <label for="project_status">Status</label>
                                <select name="project_status" id="project_status" class="form-control">
                                    <option selected disabled>Select Status</option>
                                    <option value="OPEN">OPEN</option>
                                    <option value="DOING">DOING</option>
                                    <option value="DONE">DONE</option>
                                </select>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>Save
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

    {{-- momentjs --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script>
        $(document).ready(function() {
            // global csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // datatable show
            const table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('project') }}",
                    data: function(d) {
                        d.search = $('#search').val(),
                            d.client = $('#client').val(),
                            d.status = $('#status').val()
                    },
                },
                "pageLength": 5,
                columns: [{
                        data: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'project_name',
                        name: 'project_name'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'project_start',
                        render: function(data, type, row) {
                            date = moment(data).locale('id').format('DD MMM YYYY')
                            if (date == 'Invalid date') {
                                return ''
                            }
                            return date
                        }
                    },
                    {
                        data: 'project_end',
                        render: function(data, type, row) {
                            date = moment(data).locale('id').format('DD MMM YYYY')
                            if (date == 'Invalid date') {
                                return ''
                            }
                            return date
                        }
                    },
                    {
                        data: 'project_status',
                        name: 'project_status'
                    },
                ]
            });

            // checked all row
            $(document).on('click', '#select_all', function() {
                $('.table input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });

            // delete selected
            $(document).on('click', '#delete-selected', function() {
                var ids = $('.table input[type="checkbox"]:checked').map(function() {
                    return $(this).val();
                }).get();
                if (ids.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Setidaknya pilih satu data untuk dihapus!',
                    })
                    return false;
                }
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Ingin menghapus data berikut ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('project.delete.multiple') }}",
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: ids
                            },
                            success: function(response) {
                                toastr.success(response.message)
                                // $('.table').DataTable().ajax.reload();
                                table.draw()
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                })
            });

            // show modal add
            $('#btnCreate').click(function() {
                $('#myModal').modal('show');
            });

            // store project
            $('#myForm').submit(function(event) {
                event.preventDefault();

                $('#btn-save').prop('disabled', true);
                $('#btn-save .spinner-border').removeClass('d-none');

                var formData = $(this).serialize();
                console.log(formData)

                $.ajax({
                    type: 'POST',
                    url: "{{ route('project.store') }}",
                    data: formData,
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            toastr.success(response.message);
                            $('#myModal').modal('hide');
                            $('#myForm')[0].reset();
                            table.draw();
                            removeValidation()
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        var message = xhr.responseJSON.message;
                        removeValidation()
                        if (errors) {
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '-error').text(value[0]);
                            });
                        }
                        if (message) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            });

            // remove validation
            const removeValidation = () => {
                // remove validation
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();
                // hide spinner
                $('#btn-save .spinner-border').addClass('d-none');
                // enable submit button
                $('#btn-save').prop('disabled', false);
            }

            // show modal edit
            $('body').on('click', '.editProject', function() {
                var project_id = $(this).data('id');
                $.ajax({
                    url: "project/" + project_id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('#project_id').val(data.project_id);
                        $('#project_name').val(data.project_name);
                        $('#project_start').val(data.project_start);
                        $('#project_end').val(data.project_end);
                        $('#project_status').val(data.project_status);
                        $('#client_id').val(data.client_id);
                        $('#btn-save').text('Update');
                        $('.modal-title').text('Update Project');
                        $('#myModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });

            // modal on close
            $('#myModal').on('hidden.bs.modal', function() {
                $('#myForm')[0].reset();
                removeValidation()
            })

            // search by project name
            $('.btnSearch').on('click', function(e) {
                e.preventDefault();
                table.draw();
            });

            // filter by client
            $('#client').on('change', function() {
                table.draw()
            });

            // filter by status
            $('#status').on('change', function() {
                table.draw()
            });

            // clear filter
            $('.btnClear').on('click', function(e) {
                e.preventDefault();
                $('#search-form')[0].reset();
                table.draw();
            });

        })
    </script>
@endpush
