@if(isset($rate))
    <p class="mb-0 text-muted">
        @if($rate > 0)
            <span class="text-success me-2"><i
                    class="mdi mdi-arrow-up-bold"></i> {{ (gettype($rate) === "double" or $rate < 100) ? number_format($rate, 2) : $rate }}%</span>
        @else
            <span class="text-danger me-2"><i
                    class="mdi mdi-arrow-down-bold"></i> {{ (gettype($rate) === "double" or $rate < 100) ? number_format($rate, 2) : $rate }}%</span>
        @endif
        <span class="text-nowrap">Geçen aydan beri</span>
    </p>
@endif
