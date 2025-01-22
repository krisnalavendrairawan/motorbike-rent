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
            </div>

            <div class="table-responsive">
                <table class="table" id="table-return">
                    <thead>
                        <tr>
                            <th>{{ __('label.no') }}</th>
                            <th>{{ __('label.customer') }}</th>
                            <th>{{ __('label.bike') }}</th>
                            <th>{{ __('label.return_date') }}</th>
                            <th>{{ __('label.total_price') }}</th>
                            <th>{{ __('label.status') }}</th>
                            <th class="text-center">{{ __('label.action') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showReturnModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white fw-semibold">{{ __('label.return_detail') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Motor Image Section -->
                    <div class="text-center mb-4">
                        <img id="return-motor-image" src="" alt="Motor Image" class="motor-image rounded"
                            style="height: 180px; object-fit: cover; width: 50%;">
                    </div>

                    <div class="section-title mb-4 p-3 bg-light-blue rounded">
                        <h6 class="mb-0 text-primary">Informasi Return</h6>
                    </div>

                    <div class="px-3">
                        <table class="w-100 return-info-table">
                            <tr>
                                <td class="py-2 text-secondary" width="35%">{{ __('label.customer') }}</td>
                                <td class="py-2" id="return-customer-name"></td>
                            </tr>
                            <tr>
                                <td class="py-2 text-secondary">{{ __('label.bike') }}</td>
                                <td class="py-2" id="return-motor-name"></td>
                            </tr>
                            <tr>
                                <td class="py-2 text-secondary">{{ __('label.return_date') }}</td>
                                <td class="py-2" id="return-date"></td>
                            </tr>
                            <tr>
                                <td class="py-2 text-secondary">{{ __('label.total_price') }}</td>
                                <td class="py-2" id="return-total-price"></td>
                            </tr>
                            <tr>
                                <td class="py-2 text-secondary">{{ __('label.status') }}</td>
                                <td class="py-2" id="return-status"></td>
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

        .return-info-table tr {
            border-bottom: 1px solid #e9ecef;
        }

        .return-info-table tr:last-child {
            border-bottom: none;
        }

        .return-info-table td {
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

            window.LaravelDataTables = window.LaravelDataTables || {}
            window.LaravelDataTables["table-return"] = $("#table-return").DataTable({
                dom: 'fltpr',
                language: {
                    search: "",
                    searchPlaceholder: `${label_search}...`,
                    lengthMenu: "_MENU_ Data",
                    emptyTable: label_nodata
                },
                ajax: {
                    url: "{{ route('return.datatable') }}",
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
                        render: (data, type, row, meta) => htmlEntities(row.customer_name)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.motor_name)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.formatted_return_date)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.total_price)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => {
                            let statusClass = row.status === 'finished' ? 'bg-success' :
                                'bg-warning';
                            let statusText = row.status === 'finished' ? 'Selesai' : 'Disewa';
                            return `<span class="badge ${statusClass}">${statusText}</span>`;
                        }
                    },
                    {
                        class: "align-middle text-center",
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group" role="group">
                                    <button type="button" 
                                        class="btn btn-sm btn-info text-white set-tooltip show-return" 
                                        data-bs-toggle="tooltip"
                                        data-customer-name="${htmlEntities(row.customer_name)}"
                                        data-motor-name="${htmlEntities(row.motor_name)}"
                                        data-return-date="${htmlEntities(row.formatted_return_date)}"
                                        data-total-price="${htmlEntities(row.total_price)}"
                                        data-status="${htmlEntities(row.status)}"
                                        data-motor-image="/storage/${htmlEntities(row.motor_image)}"
                                        title="Detail">
                                        <i class="bx bx-info-circle"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });

            // Handle show return modal
            $(document).on('click', '.show-return', function() {
                const customerName = $(this).data('customer-name');
                const motorName = $(this).data('motor-name');
                const motorImage = $(this).data('motor-image');
                const returnDate = $(this).data('return-date');
                const totalPrice = $(this).data('total-price');
                const status = $(this).data('status');

                $('#return-customer-name').text(customerName);
                $('#return-motor-name').text(motorName);
                $('#return-motor-image').attr('src', motorImage);
                $('#return-date').text(returnDate);
                $('#return-total-price').text(totalPrice);
                $('#return-status').html(
                    `<span class="badge ${status === 'finished' ? 'bg-success' : 'bg-warning'}">${status === 'finished' ? 'Selesai' : 'Disewa'}</span>`
                );

                $('#showReturnModal').modal('show');
            });

            $($.fn.dataTable.tables(true)).css('width', '100%');
        });
    </script>
@endpush
