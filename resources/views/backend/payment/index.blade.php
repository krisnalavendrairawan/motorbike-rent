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
                <table class="table" id="table-transaction">
                    <thead>
                        <tr>
                            <th>{{ __('label.no') }}</th>
                            <th>{{ __('label.customer') }}</th>
                            <th>{{ __('label.bike') }}</th>
                            <th>{{ __('label.order_id') }}</th>
                            <th>{{ __('label.payment_type') }}</th>
                            <th>{{ __('label.total_amount') }}</th>
                            <th>{{ __('label.status') }}</th>
                            <th>{{ __('label.payment_time') }}</th>
                            <th class="text-center">{{ __('label.action') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="modal fade" id="showTransactionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white fw-semibold">{{ __('label.payment_detail') }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <img id="transaction-motor-image" src="" alt="Motor Image" class="motor-image rounded"
                                style="height: 180px; object-fit: cover; width: 50%;">
                        </div>

                        <div class="section-title mb-4 p-3 bg-light-blue rounded">
                            <h6 class="mb-0 text-primary">Informasi Pembayaran</h6>
                        </div>

                        <div class="px-3">
                            <table class="w-100 transaction-info-table">
                                <tr>
                                    <td class="py-2 text-secondary" width="35%">{{ __('label.customer') }}</td>
                                    <td class="py-2" id="transaction-customer-name"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.bike') }}</td>
                                    <td class="py-2" id="transaction-motor-name"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.order_id') }}</td>
                                    <td class="py-2" id="transaction-order-id"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.payment_type') }}</td>
                                    <td class="py-2" id="transaction-payment-type"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.total_amount') }}</td>
                                    <td class="py-2" id="transaction-total_amount"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.status') }}</td>
                                    <td class="py-2" id="transaction-status"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.payment_time') }}</td>
                                    <td class="py-2" id="transaction-payment-date"></td>
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

        .transaction-info-table tr {
            border-bottom: 1px solid #e9ecef;
        }

        .transaction-info-table tr:last-child {
            border-bottom: none;
        }

        .transaction-info-table td {
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
            window.LaravelDataTables["table-transaction"] = $("#table-transaction").DataTable({
                dom: 'fltpr',
                language: {
                    search: "",
                    searchPlaceholder: `${label_search}...`,
                    lengthMenu: "_MENU_ Data",
                    emptyTable: label_nodata
                },
                ajax: {
                    url: "{{ route('payment.datatable') }}",
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
                        render: (data, type, row, meta) => htmlEntities(row.order_id)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => {
                            let paymentType = row.payment_type.charAt(0).toUpperCase() + row
                                .payment_type.slice(1);
                            return htmlEntities(paymentType);
                        }
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.formatted_total_amount)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => {
                            let statusClass = '';
                            let statusText = '';
                            switch (row.status) {
                                case 'pending':
                                    statusClass = 'bg-warning';
                                    statusText = 'Pending';
                                    break;
                                case 'paid':
                                    statusClass = 'bg-success';
                                    statusText = 'Paid';
                                    break;
                                case 'failed':
                                    statusClass = 'bg-danger';
                                    statusText = 'Failed';
                                    break;
                                case 'expired':
                                    statusClass = 'bg-secondary';
                                    statusText = 'Expired';
                                    break;
                            }
                            return `<span class="badge ${statusClass}">${statusText}</span>`;
                        }
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => row.payment_date ? htmlEntities(row
                            .formatted_payment_date) : '-'
                    },
                    {
                        class: "align-middle text-center",
                        searchable: false,
                        render: function(data, type, row) {
                            let actions = `<div class="btn-group" role="group">
                                        <button type="button" 
                                            class="btn btn-sm btn-info text-white set-tooltip show-transaction" 
                                            data-bs-toggle="tooltip"
                                            data-customer-name="${htmlEntities(row.customer_name)}"
                                            data-motor-name="${htmlEntities(row.motor_name)}"
                                            data-motor-image="/storage/${htmlEntities(row.motor_image)}"
                                            data-order-id="${htmlEntities(row.order_id)}"
                                            data-payment-type="${htmlEntities(row.payment_type)}"
                                           data-total_amount="${htmlEntities(row.formatted_total_amount)}"
                                            data-status="${htmlEntities(row.status)}"
                                            data-payment-date="${row.payment_date ? htmlEntities(row.formatted_payment_date) : '-'}"
                                            title="Detail">
                                            <i class="bx bx-info-circle"></i>
                                        </button>`;

                            if (row.status === 'pending' && row.payment_type === 'cash') {
                                actions += `
                                    <button type="button" 
                                        class="btn btn-sm btn-outline-success confirm-payment-btn"
                                        data-transaction-id="${row.id}"
                                        data-rental-id="${row.rental_id}"
                                        data-bs-toggle="tooltip"
                                        title="Confirm Payment">
                                        <i class="bx bx-check"></i> Konfirmasi
                                    </button>`;
                            }

                            actions += `</div>`;
                            return actions;
                        }
                    }
                ]
            });

            $($.fn.dataTable.tables(true)).css('width', '100%');

        });

        $(document).on('click', '.show-transaction', function() {
            const customerName = $(this).data('customer-name');
            const motorName = $(this).data('motor-name');
            const motorImage = $(this).data('motor-image');
            const orderId = $(this).data('order-id');
            const paymentType = $(this).data('payment-type');
            const total_amount = $(this).data('total_amount');
            const status = $(this).data('status');
            const paymentDate = $(this).data('payment-date');

            $('#transaction-customer-name').text(customerName);
            $('#transaction-motor-name').text(motorName);
            $('#transaction-motor-image').attr('src', motorImage);
            $('#transaction-order-id').text(orderId);
            $('#transaction-payment-type').text(paymentType.charAt(0).toUpperCase() + paymentType.slice(1));
            $('#transaction-total_amount').text(total_amount);
            $('#transaction-payment-date').text(paymentDate);

            let statusBadgeClass = '';
            let statusText = '';
            switch (status) {
                case 'pending':
                    statusBadgeClass = 'bg-warning';
                    statusText = 'Pending';
                    break;
                case 'paid':
                    statusBadgeClass = 'bg-success';
                    statusText = 'Paid';
                    break;
                case 'failed':
                    statusBadgeClass = 'bg-danger';
                    statusText = 'Failed';
                    break;
                case 'expired':
                    statusBadgeClass = 'bg-secondary';
                    statusText = 'Expired';
                    break;
            }

            $('#transaction-status').html(`<span class="badge ${statusBadgeClass}">${statusText}</span>`);

            $('#showTransactionModal').modal('show');
        });

        $('#table-transaction').on('click', '.confirm-payment-btn', function(e) {
            e.preventDefault();
            const button = $(this);
            const transactionId = button.data('transaction-id');
            const rentalId = button.data('rental-id');

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Konfirmasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.prop('disabled', true).html(
                        '<i class="bx bx-loader bx-spin"></i> Processing...');

                    $.ajax({
                        url: "{{ route('payment.confirm') }}",
                        type: 'POST',
                        data: {
                            transaction_id: transactionId,
                            rental_id: rentalId,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Pembayaran berhasil dikonfirmasi',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                window.LaravelDataTables["table-transaction"].ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error Response:', xhr.responseJSON);
                            let errorMessage = 'Terjadi kesalahan';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            button.prop('disabled', false)
                                .html('<i class="bx bx-check"></i> Konfirmasi');
                        }
                    });
                }
            });
        });
    </script>
@endpush
