    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="{{ $icon }}"></i>
            </span>
        </h3>

        {{ $breadcrumb_data === false ? Breadcrumbs::render($breadcrumb) : Breadcrumbs::render($breadcrumb, $breadcrumb_data) }}
    </div>
