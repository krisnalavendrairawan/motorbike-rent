@forelse($motor as $vehicle)
    <div class="col-lg-4 col-md-6">
        <div class="vehicle-card">
            <div class="vehicle-image-container">
                <span class="status-badge bg-{{ $vehicle->status === 'ready' ? 'success' : 'danger' }}">
                    {{ $vehicle->status === 'ready' ? 'Available' : 'Not Available' }}
                </span>
                <img src="{{ asset('storage/' . $vehicle->image) }}" 
                     alt="{{ $vehicle->name }}" 
                     class="vehicle-image">
            </div>
            <div class="vehicle-details">
                <h4 class="mb-3">{{ $vehicle->name }}</h4>
                <div class="vehicle-info-grid">
                    <div class="vehicle-info">
                        <i class="fas fa-road info-icon"></i>
                        <div>
                            <span class="info-label">Type</span>
                            <span>{{ $vehicle->type }}</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <i class="fas fa-gas-pump info-icon"></i>
                        <div>
                            <span class="info-label">Brand</span>
                            <span>{{ $vehicle->brand->name }}</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <i class="fas fa-palette info-icon"></i>
                        <div>
                            <span class="info-label">Color</span>
                            <span>{{ $vehicle->color }}</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <i class="fas fa-tag info-icon"></i>
                        <div>
                            <span class="info-label">Price/Day</span>
                            <span>Rp {{ number_format($vehicle->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <button class="btn book-now-btn" 
                        {{ $vehicle->status !== 'ready' ? 'disabled' : '' }}>
                    Book Now
                </button>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            No vehicles available at the moment.
        </div>
    </div>
@endforelse