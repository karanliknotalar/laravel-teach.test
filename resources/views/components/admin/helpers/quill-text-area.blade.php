<div class="{{ $parentClass ?? "mb-3" }}">
    <input type="hidden" name="{{ $name ?? "" }}" id="{{ $hiddenId ?? "quilltext" }}">
    <h6 class="{{ $titleClass ?? "mb-2" }}">{{ $title ?? "İçerik" }}</h6>
    <div id="{{ $quillElementId ?? "snow-editor" }}" style="{{ $quillStyle ?? "height: 300px;" }}">
        {!! $content ?? "" !!}
    </div>
</div>
