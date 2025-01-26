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
                <a href="{{ route('service.create') }}" class="btn btn-primary btn-sm me-5 mt-3">
                    <i class='bx bxs-user-plus'></i> &nbsp;{{ __('label.create') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table" id="table-service">
                    <thead>
                        <tr>
                            <th>{{ __('label.no') }}</th>
                            <th>{{ __('label.bike') }}</th>
                            <th>{{ __('label.service_date') }}</th>
                            <th>{{ __('label.service_type') }}</th>
                            <th>{{ __('label.cost') }}</th>
                            <th>{{ __('label.status') }}</th>
                            <th class="text-center">{{ __('label.action') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <!-- Show Modal -->
        <div class="modal fade" id="showServiceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white fw-semibold">{{ __('label.service_detail') }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <!-- Motor Image Section -->
                        <div class="text-center mb-4">
                            <img id="service-motor-image" src="" alt="Motor Image" class="motor-image rounded"
                                style="height: 180px; object-fit: cover; width: 50%;">
                        </div>
                        <div class="section-title mb-4 p-3 bg-light-blue rounded">
                            <h6 class="mb-0 text-primary">Informasi Service</h6>
                        </div>

                        <!-- Data Table -->
                        <div class="px-3">
                            <table class="w-100 service-info-table">
                                <tr>
                                    <td class="py-2 text-secondary" width="35%">{{ __('label.bike') }}</td>
                                    <td class="py-2" id="service-motor-name"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.service_date') }}</td>
                                    <td class="py-2" id="service-date"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.service_type') }}</td>
                                    <td class="py-2" id="service-type"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.cost') }}</td>
                                    <td class="py-2" id="service-cost"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.service_detail') }}</td>
                                    <td class="py-2" id="service-description"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.status') }}</td>
                                    <td class="py-2" id="service-status"></td>
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
    <link href="{{ asset('vendors/datatables/DataTables-1.13.6/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <style>
        .modal-dialog {
            max-width: 650px;
        }

        .bg-light-blue {
            background-color: #f8f9ff;
        }

        .service-info-table tr {
            border-bottom: 1px solid #e9ecef;
        }

        .service-info-table tr:last-child {
            border-bottom: none;
        }

        .service-info-table td {
            font-size: 14px;
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
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js"></script>
    <script src="{{ asset('vendors/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/datatables/DataTables-1.13.6/js/dataTables.bootstrap5.min.js') }}"
        type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const table = $("#table-service").DataTable({
                dom: 'fltpr',
                language: {
                    search: "",
                    searchPlaceholder: `${label_search}...`,
                    lengthMenu: "_MENU_ Data",
                    emptyTable: label_nodata
                },
                ajax: {
                    url: "{{ route('service.datatable') }}",
                    type: "POST"
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
                        render: (data, type, row, meta) => htmlEntities(row.motor_name)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.formatted_service_date)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.service_type)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.formatted_cost)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => {
                            const status = row.status || 'pending';
                            const badgeClass = status === 'completed' ? 'bg-success' : 'bg-warning';
                            return `<span class="badge ${badgeClass}">${status}</span>`;
                        }
                    },
                    {
                        class: "align-middle text-center",
                        searchable: false,
                        render: function(data, type, row) {
                            const detailBtn = `<button type="button" 
                                class="btn btn-sm btn-info text-white set-tooltip show-service" 
                                data-bs-toggle="tooltip"
                                data-motor-name="${htmlEntities(row.motor_name)}"
                                data-service-date="${htmlEntities(row.formatted_service_date)}"
                                data-service-type="${htmlEntities(row.service_type)}"
                                data-cost="${htmlEntities(row.formatted_cost)}"
                                data-description="${htmlEntities(row.description)}"
                                data-status="${htmlEntities(row.status)}"
                                data-motor-image="/storage/${htmlEntities(row.motor_image)}"
                                title="Detail">
                                <i class="bx bx-info-circle"></i>
                            </button>`;

                            const editBtn = `<a 
                                href="/service/${row.id}/edit" 
                                class="btn btn-sm btn-warning set-tooltip" 
                                data-bs-toggle="tooltip"
                                title="Edit">
                                <i class="bx bx-edit"></i>
                            </a>`;

                            const completeBtn = row.status !== 'completed' ?
                                `<button 
                                class="btn btn-sm btn-outline-success set-tooltip complete-service" 
                                data-id="${row.id}"
                                data-bs-toggle="tooltip"
                                title="Complete Service">
                                    <i class='bx bx-check-shield'></i> Selesai
                            </button>` : '';

                            return `<div class="btn-group" role="group">
                ${detailBtn}
                ${editBtn}
                ${completeBtn}
            </div>`;
                        }
                    }
                ]
            });

            $(document).on('click', '.show-service', function() {
                const motorName = $(this).data('motor-name');
                const motorImage = $(this).data('motor-image');
                const serviceDate = $(this).data('service-date');
                const serviceType = $(this).data('service-type');
                const cost = $(this).data('cost');
                const description = $(this).data('description');
                const status = $(this).data('status');

                $('#service-motor-name').text(motorName);
                $('#service-motor-image').attr('src', motorImage);
                $('#service-date').text(serviceDate);
                $('#service-type').text(serviceType);
                $('#service-cost').text(cost);
                $('#service-description').text(description);
                $('#service-status').html(
                    `<span class="badge ${status === 'completed' ? 'bg-success' : 'bg-warning'}">${status}</span>`
                );

                $('#showServiceModal').modal('show');
            });

            $('#table-service').on('click', '.complete-service', function() {
                const serviceId = $(this).data('id');

                Swal.fire({
                    title: 'Selesaikan Servis',
                    text: 'Apakah Anda yakin ingin menandai servis ini sebagai selesai?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, selesaikan!',
                    cancelButtonText: 'Tidak, batalkan',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/service/${serviceId}/complete`,
                            type: 'POST',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Servis telah ditandai sebagai selesai.',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        table.ajax.reload(null, false);
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Kesalahan!',
                                        text: response.message ||
                                            'Gagal menyelesaikan servis',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Kesalahan!',
                                    text: xhr.responseJSON?.message ||
                                        'Gagal menyelesaikan servis',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            $($.fn.dataTable.tables(true)).css('width', '100%');
        });
    </script>
@endpush
