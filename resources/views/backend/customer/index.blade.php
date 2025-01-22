@extends('layouts.backend.index')

@section('title', $title)

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('page-action')
    <li class="breadcrumb-item text-light">
        <x-profile />
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row-reverse bd-highlight">

                <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm me-5 mt-3">
                    <i class='bx bxs-user-plus'></i> &nbsp;{{ __('label.create') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table" id="table-customer">
                    <thead>
                        <tr>
                            <th>{{ __('label.no') }}</th>
                            <th>{{ __('label.name') }}</th>
                            <th>{{ __('label.nik') }}</th>
                            <th>{{ __('label.email') }}</th>
                            <th>{{ __('label.phone_number') }}</th>
                            {{-- <th>{{ __('label.driver_license') }}</th> --}}
                            <th class="text-center">{{ __('label.action') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('vendors/datatables/DataTables-1.13.6/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <style>
        .page-title-box {

            padding: 1.5rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('vendors/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/datatables/DataTables-1.13.6/js/dataTables.bootstrap5.min.js') }}"
        type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            window.LaravelDataTables = window.LaravelDataTables || {}
            window.LaravelDataTables["table-customer"] = $("#table-customer").DataTable({
                dom: 'fltpr',
                language: {
                    search: "",
                    searchPlaceholder: `${label_search}...`,
                    lengthMenu: "_MENU_ Data",
                    emptyTable: label_nodata
                },
                ajax: {
                    url: "{{ route('customer.datatable') }}",
                    type: "POST",
                },
                processing: true,
                serverSide: true,
                deferRender: true,
                ordering: false,
                aLengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                drawCallback: function() {
                    $(".set-tooltip").tooltip({
                        container: "body"
                    })
                },
                columns: [{
                        class: "align-middle",
                        width: "50px",
                        searchable: false,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.name)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.nik)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.email)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.phone)
                    },
                    {
                        class: "align-middle text-center",
                        searchable: false,
                        render: function(data, type, row) {
                            let url_show = "{{ route('customer.show', ':id') }}";
                            let url_edit = "{{ route('customer.edit', ':id') }}";
                            let url_destroy = "{{ route('customer.destroy', ':id') }}";

                            url_show = url_show.replace(':id', encodeURIComponent(row
                                .encrypted_id));
                            url_edit = url_edit.replace(':id', encodeURIComponent(row
                                .encrypted_id));
                            url_destroy = url_destroy.replace(':id', encodeURIComponent(row
                                .encrypted_id));

                            return `
                            <a href="${url_show}" class="btn btn-icon btn-primary set-tooltip" title="${label_show}">
                                <i class='bx bxs-user-detail'></i>
                            </a>
                            <a href="${url_edit}" class="btn btn-icon btn-dark set-tooltip" title="${label_edit}">
                                <i class='bx bx-edit'></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-icon btn-danger" title="${label_delete}" onclick="deleteConfirm('${url_destroy}', false, 'table-customer')">
                                <i class='bx bx-trash-alt'></i>
                            </a>`
                        }
                    }
                ]
            })

            $($.fn.dataTable.tables(true)).css('width', '100%')
        });
    </script>
@endpush
