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

                <a href="{{ route('brand.create') }}" class="btn btn-primary btn-sm me-5 mt-3">
                    <i class='bx bxs-user-plus'></i> &nbsp;{{ __('label.create') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table" id="table-brand">
                    <thead>
                        <tr>
                            <th>{{ __('label.no') }}</th>
                            <th>{{ __('label.name') }}</th>
                            <th>{{ __('label.logo') }}</th>
                            <th class="text-center">{{ __('label.action') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="col-lg-4 col-md-6">
                <!-- Show Modal -->
                <div class="modal fade" id="showBrandModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white fw-semibold">{{ __('label.brand_detail') }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="section-title mb-4 p-3 bg-light-blue rounded">
                                    <h6 class="mb-0 text-primary">Informasi Brand</h6>
                                </div>

                                <!-- Data Table -->
                                <div class="px-3">
                                    <table class="w-100 brand-info-table">
                                        <tr>
                                            <td class="py-2 text-secondary" width="35%">{{ __('label.name') }}</td>
                                            <td class="py-2" id="brand-name"></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-secondary">{{ __('label.description') }}</td>
                                            <td class="py-2" id="brand-description"></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-secondary">{{ __('label.total_bikes') }}</td>
                                            <td class="py-2" id="brand-motor-count"></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 text-secondary">{{ __('label.logo') }}</td>
                                            <td class="py-2">
                                                <img id="brand-logo" src="" alt="Brand Logo" class="img-fluid"
                                                    style="max-width: 200px">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                    {{ __('label.close') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection

        @push('styles')
            <link href="{{ asset('vendors/datatables/DataTables-1.13.6/css/dataTables.bootstrap5.min.css') }}"
                rel="stylesheet">
            <style>
                .page-title-box {

                    padding: 1.5rem;
                    border-radius: 0.375rem;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                }

                .modal-dialog {
                    max-width: 650px;
                }

                .bg-light-blue {
                    background-color: #f8f9ff;
                }

                .brand-info-table tr {
                    border-bottom: 1px solid #e9ecef;
                }

                .brand-info-table tr:last-child {
                    border-bottom: none;
                }

                .brand-info-table td {
                    font-size: 14px;
                }

                .text-secondary {
                    color: #6c757d !important;
                }

                .modal-header {
                    padding: 15px 20px;
                }

                .modal-footer {
                    padding: 15px 24px;
                    border-top: none;
                }

                .section-title h6 {
                    font-size: 14px;
                    font-weight: 600;
                }

                .btn {
                    font-size: 14px;
                    padding: 8px 16px;
                }

                .btn-success {
                    background-color: #28a745;
                    border-color: #28a745;
                }

                .btn-outline-secondary {
                    color: #6c757d;
                    border-color: #6c757d;
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
                    window.LaravelDataTables["table-brand"] = $("#table-brand").DataTable({
                        dom: 'fltpr',
                        language: {
                            search: "",
                            searchPlaceholder: `${label_search}...`,
                            lengthMenu: "_MENU_ Data",
                            emptyTable: label_nodata
                        },
                        ajax: {
                            url: "{{ route('brand.datatable') }}",
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
                                data: 'logo',
                                name: 'logo',
                                render: function(data, type, full, meta) {
                                    return data ? "<img src='" + "{{ asset('storage') }}/" + data +
                                        "' class='img-fluid' style='max-width: 100px' />" : '';
                                }
                            },
                            {
                                class: "align-middle text-center",
                                searchable: false,
                                render: function(data, type, row) {
                                    let url_show = "{{ route('brand.show', ':id') }}";
                                    let url_edit = "{{ route('brand.edit', ':id') }}";
                                    let url_destroy = "{{ route('brand.destroy', ':id') }}";

                                    url_show = url_show.replace(':id', encodeURIComponent(row
                                        .encrypted_id));
                                    url_edit = url_edit.replace(':id', encodeURIComponent(row
                                        .encrypted_id));
                                    url_destroy = url_destroy.replace(':id', encodeURIComponent(row
                                        .encrypted_id));

                                    return `
                <button type="button" class="btn btn-icon btn-primary set-tooltip show-brand" 
                        data-name="${htmlEntities(row.name)}"
                        data-description="${htmlEntities(row.description)}"
                        data-logo="${row.image_url}"
                        data-motor-count="${row.motor_count}"
                        title="${label_show}">
                    <i class='bx bxs-user-detail'></i>
                </button>
                <a href="${url_edit}" class="btn btn-icon btn-dark set-tooltip" title="${label_edit}">
                    <i class='bx bx-edit'></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-icon btn-danger" title="${label_delete}" onclick="deleteConfirm('${url_destroy}', false, 'table-brand')">
                    <i class='bx bx-trash-alt'></i>
                </a>`
                                }
                            }
                        ]
                    })
                    $(document).on('click', '.show-brand', function() {
                        const name = $(this).data('name');
                        const description = $(this).data('description');
                        const logo = $(this).data('logo');
                        const motorCount = $(this).data('motor-count');

                        $('#brand-name').text(name);
                        $('#brand-description').text(description);
                        $('#brand-logo').attr('src', logo);
                        $('#brand-motor-count').text(motorCount);

                        $('#showBrandModal').modal('show');
                    });
                    $($.fn.dataTable.tables(true)).css('width', '100%')
                });
                window.LaravelDataTables = window.LaravelDataTables || {}
                window.LaravelDataTables["table-brand"] = $("#table-brand").DataTable({
                    dom: 'fltpr',
                    language: {
                        search: "",
                        searchPlaceholder: `${label_search}...`,
                        lengthMenu: "_MENU_ Data",
                        emptyTable: label_nodata
                    },
                    ajax: {
                        url: "{{ route('brand.datatable') }}",
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
                            data: 'logo',
                            name: 'logo',
                            render: function(data, type, full, meta) {
                                return data ? "<img src='" + "{{ asset('storage') }}/" + data +
                                    "' class='img-fluid' style='max-width: 100px' />" : '';
                            }
                        },
                        {
                            class: "align-middle text-center",
                            searchable: false,
                            render: function(data, type, row) {
                                let url_show = "{{ route('brand.show', ':id') }}";
                                let url_edit = "{{ route('brand.edit', ':id') }}";
                                let url_destroy = "{{ route('brand.destroy', ':id') }}";

                                url_show = url_show.replace(':id', encodeURIComponent(row
                                    .encrypted_id));
                                url_edit = url_edit.replace(':id', encodeURIComponent(row
                                    .encrypted_id));
                                url_destroy = url_destroy.replace(':id', encodeURIComponent(row
                                    .encrypted_id));

                                return `
                                    <button type="button" class="btn btn-icon btn-primary set-tooltip show-brand" 
                                            data-name="${htmlEntities(row.name)}"
                                            data-description="${htmlEntities(row.description)}"
                                            data-logo="${row.image_url}"
                                            data-motor-count="${row.motor_count}"
                                            title="${label_show}">
                                        <i class='bx bxs-user-detail'></i>
                                    </button>
                                    <a href="${url_edit}" class="btn btn-icon btn-dark set-tooltip" title="${label_edit}">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-danger" title="${label_delete}" onclick="deleteConfirm('${url_destroy}', false, 'table-brand')">
                                        <i class='bx bx-trash-alt'></i>
                                    </a>`
                            }
                        }
                    ]
                })
                $(document).on('click', '.show-brand', function() {
                    const name = $(this).data('name');
                    const description = $(this).data('description');
                    const logo = $(this).data('logo');
                    const motorCount = $(this).data('motor-count');

                    $('#brand-name').text(name);
                    $('#brand-description').text(description);
                    $('#brand-logo').attr('src', logo);
                    $('#brand-motor-count').text(motorCount);

                    $('#showBrandModal').modal('show');
                });
            </script>
        @endpush
