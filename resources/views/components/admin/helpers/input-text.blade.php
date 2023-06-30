<div class="{{ $mainClass ?? "form-floating mb-3" }}">
    <input type="text"
           class="{{ $elementClass ?? "form-control" }}"
           placeholder="{{ $placeHolder ?? ($title ?? "") }}"
           name="{{ $name ?? "" }}"
           id="{{ $name ?? "" }}"
           value="{{ $value }}">
    <label for="{{ $name ?? "" }}">{{ $title ?? "" }}</label>
</div>
