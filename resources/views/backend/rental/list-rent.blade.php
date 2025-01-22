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
                <table class="table" id="table-rental">
                    <thead>
                        <tr>
                            <th>{{ __('label.no') }}</th>
                            <th>{{ __('label.customer') }}</th>
                            <th>{{ __('label.bike') }}</th>
                            <th>{{ __('label.start_date_rent') }}</th>
                            <th>{{ __('label.end_date_rent') }}</th>
                            <th>{{ __('label.status') }}</th>
                            <th>{{ __('label.total_price') }}</th>
                            <th class="text-center">{{ __('label.action') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="modal fade" id="showRentalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white fw-semibold">{{ __('label.rental_detail') }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <img id="rental-motor-image" src="" alt="Motor Image" class="motor-image rounded"
                                style="height: 180px; object-fit: cover; width: 50%;">
                        </div>

                        <div class="section-title mb-4 p-3 bg-light-blue rounded">
                            <h6 class="mb-0 text-primary">Informasi Penyewaan</h6>
                        </div>

                        <div class="px-3">
                            <table class="w-100 rental-info-table">
                                <tr>
                                    <td class="py-2 text-secondary" width="35%">{{ __('label.customer') }}</td>
                                    <td class="py-2" id="rental-customer-name"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.bike') }}</td>
                                    <td class="py-2" id="rental-motor-name"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.start_date_rent') }}</td>
                                    <td class="py-2" id="rental-start-date"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.end_date_rent') }}</td>
                                    <td class="py-2" id="rental-end-date"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.total_price') }}</td>
                                    <td class="py-2" id="rental-total-price"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-secondary">{{ __('label.status') }}</td>
                                    <td class="py-2" id="rental-status"></td>
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

        .rental-info-table tr {
            border-bottom: 1px solid #e9ecef;
        }

        .rental-info-table tr:last-child {
            border-bottom: none;
        }

        .rental-info-table td {
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
            window.LaravelDataTables["table-rental"] = $("#table-rental").DataTable({
                dom: 'fltpr',
                language: {
                    search: "",
                    searchPlaceholder: `${label_search}...`,
                    lengthMenu: "_MENU_ Data",
                    emptyTable: label_nodata
                },
                ajax: {
                    url: "{{ route('rental.datatable') }}",
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
                        render: (data, type, row, meta) => htmlEntities(row.formatted_start_date)
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.formatted_end_date)
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
                                case 'rent':
                                    statusClass = 'bg-primary';
                                    statusText = 'Disewa';
                                    break;
                                case 'finished':
                                    statusClass = 'bg-success';
                                    statusText = 'Selesai';
                                    break;
                                case 'returned':
                                    statusClass = 'bg-info';
                                    statusText = 'Dikembalikan';
                                    break;
                                case 'cancelled':
                                    statusClass = 'bg-danger';
                                    statusText = 'Dibatalkan';
                                    break;
                            }
                            return `<span class="badge ${statusClass}">${statusText}</span>`;
                        }
                    },
                    {
                        class: "align-middle",
                        render: (data, type, row, meta) => htmlEntities(row.formatted_price)
                    },
                    {
                        class: "align-middle text-center",
                        searchable: false,
                        render: function(data, type, row) {
                            let actions = `<div class="btn-group" role="group">
                                        <button type="button" 
                                            class="btn btn-sm btn-info text-white set-tooltip show-rental" 
                                            data-bs-toggle="tooltip"
                                            data-customer-name="${htmlEntities(row.customer_name)}"
                                            data-motor-name="${htmlEntities(row.motor_name)}"
                                            data-motor-image="/storage/${htmlEntities(row.motor_image)}"
                                            data-start-date="${htmlEntities(row.formatted_start_date)}"
                                            data-end-date="${htmlEntities(row.formatted_end_date)}"
                                            data-total-price="${htmlEntities(row.formatted_price)}"
                                            data-status="${htmlEntities(row.status)}"
                                            title="Detail">
                                            <i class="bx bx-info-circle"></i>
                                        </button>`;

                            if (row.status === 'pending' && row.payment_type === 'cash') {
                                actions += `
                                    <button type="button" 
                                        class="btn btn-sm btn-outline-info confirm-payment-btn"
                                        data-rental-id="${row.id}"
                                        data-bs-toggle="tooltip"
                                        title="Confirm Payment">
                                        <i class="bx bx-money"></i> Confirm Payment
                                    </button>`;
                            }

                            if (row.status === 'rent') {
                                actions += `
                                    <a href="#" 
                                    class="btn btn-sm btn-outline-success btn-complete-rental" 
                                    data-rental-id="${row.id}"
                                    data-bs-toggle="tooltip"
                                    title="Complete Rental">
                                        <i class='bx bx-check-shield'></i> Selesai
                                    </a>`;
                            }

                            actions += `</div>`;
                            return actions;
                        }
                    }
                ]
            });

            $($.fn.dataTable.tables(true)).css('width', '100%');

        });

        $('#table-rental').on('click', '.btn-complete-rental', function(e) {
            e.preventDefault();
            const button = $(this);
            const rentalId = button.data('rental-id');

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menyelesaikan penyewaan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    button.prop('disabled', true).html(
                        '<i class="bx bx-loader bx-spin"></i> Processing...');

                    $.ajax({
                        url: "{{ route('return.store') }}",
                        type: 'POST',
                        data: {
                            rental_id: rentalId,
                            return_date: moment().format('YYYY-MM-DD HH:mm:ss'),
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                window.LaravelDataTables["table-rental"].ajax.reload();
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
                            // Reset button state
                            button.prop('disabled', false)
                                .html('<i class="bx bx-check-shield"></i> Selesai');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.show-rental', function() {
            const customerName = $(this).data('customer-name');
            const motorName = $(this).data('motor-name');
            const motorImage = $(this).data('motor-image');
            const startDate = $(this).data('start-date');
            const endDate = $(this).data('end-date');
            const totalPrice = $(this).data('total-price');
            const status = $(this).data('status');

            $('#rental-customer-name').text(customerName);
            $('#rental-motor-name').text(motorName);
            $('#rental-motor-image').attr('src', motorImage);
            $('#rental-start-date').text(startDate);
            $('#rental-end-date').text(endDate);
            $('#rental-total-price').text(totalPrice);

            let statusBadgeClass = '';
            let statusText = '';
            switch (status) {
                case 'rent':
                    statusBadgeClass = 'bg-primary';
                    statusText = 'Disewa';
                    break;
                case 'finished':
                    statusBadgeClass = 'bg-success';
                    statusText = 'Selesai';
                    break;
                case 'pending':
                    statusBadgeClass = 'bg-pending';
                    statusText = 'Pending';
                    break;
                case 'returned':
                    statusBadgeClass = 'bg-info';
                    statusText = 'Dikembalikan';
                    break;
                case 'cancel':
                    statusBadgeClass = 'bg-danger';
                    statusText = 'Dibatalkan';
                    break;
            }

            $('#rental-status').html(`<span class="badge ${statusBadgeClass}">${statusText}</span>`);

            $('#showRentalModal').modal('show');
        });

        $('#table-rental').on('click', '.confirm-payment-btn', function(e) {
            e.preventDefault();
            const button = $(this);
            const rentalId = button.data('rental-id');

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah customer ini sudah membayar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Sudah Bayar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.prop('disabled', true).html(
                        '<i class="bx bx-loader bx-spin"></i> Processing...');

                    $.ajax({
                        url: "{{ route('rental.confirm-payment') }}",
                        type: 'POST',
                        data: {
                            rental_id: rentalId,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Pembayaran berhasil dikonfirmasi',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                window.LaravelDataTables["table-rental"].ajax.reload();
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
                                .html('<i class="bx bx-money"></i> Confirm Payment');
                        }
                    });
                }
            });
        });
    </script>
@endpush
