<div class="{{ $parentClass ?? "mb-3" }}">
    <label
        for="{{ $name ?? "image" }}"
        class="{{ $labelClass ?? "mb-1" }}">
        {{ $title ?? "Resim Seç (1900x890)" }}
    </label>
    <input
        type="file" id="{{ $name ?? "image" }}"
        class="{{ $inputClass ?? "form-control" }}"
        name="{{ $name ?? "image" }}">
</div>
