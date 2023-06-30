<div class="{{ $mainClass ?? "mb-3" }} form-floating ">
    <input type="{{ $inputType ?? "text" }}"
           class="{{ $elementClass ?? "" }} form-control"
           placeholder="{{ $placeHolder ?? ($title ?? "") }}"
           name="{{ $name ?? "" }}"
           id="{{ $name ?? "" }}"
           value="{{ $value }}">
    <label for="{{ $name ?? "" }}">{{ $title ?? "" }}</label>
</div>
