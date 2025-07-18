<div class="d-flex">
    <div class="p-2 flex-grow-1">
        <h4 class="text-primary">
            @isset($icon)
                <i class="bi bi-{{ $icon }} me-1"></i>
            @endisset
            {{ $title }}
        </h4>
    </div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach ($breadcrumbs as $item)
                    @if ($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $item }}</li>
                    @else
                        <li class="breadcrumb-item text-primary">{{ $item }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>
