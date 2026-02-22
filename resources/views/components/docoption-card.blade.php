@props([
    'title',
    'description',
    'route',
    'icon' => 'bi-file-earmark-text',
    'iconColor' => 'primary'
])

<div class="col-md-4">
    <div class="card h-100 shadow-sm border-0">
        <div class="card-body d-flex flex-column">
            <div class="mb-3">
                <i class="fa {{ $icon }}"></i>
            </div>
            <h5 class="card-title">{{ $title }}</h5>
            <p class="card-text text-muted flex-grow-1">
                {{ $description }}
            </p>
            <a href="{{ $route }}" class="btn btn-primary mt-auto">
                Buat Dokumen
            </a>
        </div>
    </div>
</div>