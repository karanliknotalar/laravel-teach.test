<li class="side-nav-item">
    <a href="{{ $url }}" class="side-nav-link">
        <i class="{{ $iconName }}"></i>
        @if(isset($count))
            <span class="badge bg-primary float-end">{{ $count }}</span>
        @endif
        <span>{{ $name }}</span>
    </a>
</li>
