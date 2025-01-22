<div class="row g-4">
    @forelse($motor as $bike)
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-shadow transition">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $bike->image) }}" class="card-img-top" alt="{{ $bike->name }}"
                        style="height: 250px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-{{ $bike->status === 'ready' ? 'success' : 'danger' }}">
                            {{ $bike->status === 'ready' ? 'Ready' : 'Not Ready' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $bike->name }}</h5>
                    <p class="text-muted small mb-2">
                        <i class='bx bxs-badge'></i> {{ $bike->plate }}
                    </p>
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $bike->brand->name }}</span>
                        <span class="badge bg-info">{{ $bike->type }}</span>
                        <span class="badge" style="background-color: {{ $bike->color }}">
                            {{ $bike->color }}
                        </span>
                    </div>
                    <p class="card-text text-truncate" title="{{ $bike->description }}">
                        {{ $bike->description }}
                    </p>
                    <h6 class="fw-bold text-primary mb-3">
                        Rp {{ number_format($bike->price, 0, ',', '.') }} / Days
                    </h6>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex gap-2"> <!-- Tambahkan div dengan gap -->
                            <a href="{{ route('bike.show', $bike->id) }}" class="btn btn-outline-info btn-sm">
                                <i class='bx bxs-show'></i> Detail
                            </a>
                            <a href="{{ route('bike.edit', $bike->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class='bx bxs-edit'></i> Edit
                            </a>
                        </div>
                        <form id="delete-form-{{ $bike->id }}" action="{{ route('bike.destroy', $bike->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                data-id="{{ $bike->id }}">
                                <i class='bx bxs-trash'></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                No bikes available yet. Click "Add New Bike" to add one!
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        Showing {{ $motor->firstItem() ?? 0 }} to {{ $motor->lastItem() ?? 0 }} of {{ $motor->total() }}
        entries
    </div>
    <div>
        {{ $motor->onEachSide(1)->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
</div>
