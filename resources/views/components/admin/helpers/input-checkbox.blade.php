<div class="{{ $parentClass ?? "mb-4" }}">
    <div class="d-flex">
        <label
            class="{{ $labelClass ?? "label-default me-2" }}">
            {{ $labelTitle ?? "Durum:" }}
        </label>
        <input type="checkbox"
               id="{{ $name ?? "status" }}"
               data-switch="success"
               name="{{ $name ?? "status" }}"
            {{ $checkedStatus ?? ""}}/>
        <label for="{{ $name ?? "status" }}"
               data-on-label="{{ $onText ?? "On" }}"
               data-off-label="{{ $offText ?? "Off" }}"
               class="mb-0 d-block">
        </label>
    </div>
</div>
