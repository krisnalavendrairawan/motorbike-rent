<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0 mt-2">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center">
                <div class="input-group w-auto me-3">
                    <input type="text" class="form-control form-control-sm border-0 bg-light"
                        placeholder="{{ __('label.search') }}...">
                </div>
                <a href="{{ route('user.create') }}" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bx-plus font-size-16 align-middle me-2"></i> CREATE
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="table-user">
                <thead>
                    <tr>
                        <th>{{ __('label.no') }}</th>
                        <th>{{ __('label.name') }}</th>
                        <th>{{ __('label.email') }}</th>
                        <th>{{ __('label.phone_number') }}</th>
                        <th class="text-center">{{ __('label.action') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .page-title-box {
            background: #fff;
            padding: 1.5rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #6c757d;
        }

        .breadcrumb-item a {
            color: #6c757d;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #495057;
        }
    </style>
@endpush
