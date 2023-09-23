<li class="side-nav-item">
    <a href="{{ $url }}" class="side-nav-link">
        @if(isset($iconName))
            <i class="{{ $iconName }}"></i>
        @endif
        @if(isset($count))
            <span class="badge {{ $counterColor ?? "bg-primary" }} float-end">{{ $count }}</span>
        @endif
        <span>{{ $name }}</span>
    </a>
</li>
