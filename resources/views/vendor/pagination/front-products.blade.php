@if($paginator->hasPages())
    <div class="row" data-aos="fade-up">
        <div class="col-md-12 text-center">
            <div class="site-block-27">
                <ul>
                    @if($paginator->previousPageUrl())
                        <li><a href="{{ $paginator->previousPageUrl() }}">&lt;</a></li>
                    @endif

                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class=" active" aria-current="page"><span>{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if($paginator->hasMorePages())
                        <li><a href="{{ $paginator->nextPageUrl() }}">&gt;</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
