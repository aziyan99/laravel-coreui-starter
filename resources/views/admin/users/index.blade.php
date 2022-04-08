@extends('layouts.admin')

@section('title', 'Pengguna')

@section('breadcump')
    <li class="breadcrumb-item">
        <a href="#">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('users.index') }}">{{ __('Pengguna') }}</a>
    </li>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            @can('user_create')
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mb-2">
                <svg class="icon icon-sm me-1">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                </svg>
                {{ __('Tambah') }}
            </a>
            @endcan
            <div class="card">
                <div class="card-header">{{ __('Data pengguna') }}</div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-sm" id="users">
                        <thead>
                        <tr>
                            <th>{{ __('ID.') }}</th>
                            <th>{{ __('Nama') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>{{ __('ID.') }}</th>
                            <th>{{ __('Nama') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content" id="delete-form">
        </div>
    </div>
</div>
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.4/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.1/fh-3.2.1/r-2.2.9/sc-2.0.5/sb-1.3.1/sp-1.4.0/datatables.min.css" />
    <style>
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
        .dt-buttons {
            margin-bottom: 30px;
        }
    </style>

@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js">
    </script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.4/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.1/fh-3.2.1/r-2.2.9/sc-2.0.5/sb-1.3.1/sp-1.4.0/datatables.min.js">
    </script>
    <script>
        $(function () {
            $('#users tfoot th').each(function () {
                const title = $(this).text();
                $(this).html('<input type="text" placeholder="Cari ' + title + '" />');
            });
            var table = $('#users').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ],
                lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                // fixedHeader: true,
                // scrollY: 400,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                    data: 'id',
                    name: 'id'
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'Aksi',
                        name: 'Aksi',
                        orderable: true,
                        searchable: true
                    },
                ],
                initComplete: function () {
                    // Apply the search
                    this.api().columns().every(function () {
                        var that = this;
                        $('input', this.footer()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                    reloadDeleteModal();
                },
                drawCallback: function () {
                reloadDeleteModal();
            }
            });

            const reloadDeleteModal = () => {

                const deleteBtn = document.querySelectorAll('a.delete-btn');
                const deleteModal = new bootstrap.Modal(document.querySelector('div#deleteModal'), {});
                const generateDestroyUri = (id) => {
                    return "{{ route('users.index') }}/" + id;
                }
                deleteBtn.forEach( el => {
                    el.addEventListener('click', e => {
                        const id = el.getAttribute("data-id");
                        const route = generateDestroyUri(id);
                        const deleteForm = document.querySelector('div#delete-form');
                        let form = `<form action="${route}" method="post">`;
                        form += '{{ csrf_field() }}';
                        form += '{{ method_field("DELETE") }}';
                        form += '<div class="modal-header">';
                        form += '<h5 class="modal-title">{{ __("Hapus pengguna") }}</h5>';
                        form += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                        form += '</div>';
                        form += '<div class="modal-body">';
                        form += '<div class="alert alert-info">{{ __("Hapus pengguna ini? Proses ini tidak bisa dibatalkan.") }}</div>';
                        form += '</div>';
                        form += ' <div class="modal-footer">';
                        form += '<button type="button" class="btn btn-secondary text-white" id="#dismiss-modal">{{ __("Batal") }}</button>';
                        form += '<button class="btn btn-danger text-white" type="submit">{{ __("Hapus") }}</button>';
                        form += '</div>';
                        form += '</form>';
                        deleteForm.innerHTML = form;
                        deleteModal.toggle();
                        const dismissModalBtn = document.querySelector('#dismiss-modal').addEventListener('click', () => {
                            deleteModal.hide();
                            $('.modal-backdrop').remove();
                        });
                    });
                });
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-coreui-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new coreui.Tooltip(tooltipTriggerEl)
                });
            }

        });

    </script>
@endpush
