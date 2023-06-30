<button {{ $attributes }}
    type="{{ $type ?? "button" }}"
    class="{{ $class ?? "btn btn-primary" }}"
    @if($overText ?? false)
        tabindex="0"
    data-bs-placement="{{ $placement ?? "top" }}"
    data-bs-toggle="{{ $toggle ?? "popover" }}"
    data-bs-trigger="{{ $trigger ?? "hover" }}"
    data-bs-content="{{ $message ?? "Mesajınız..." }}"
    @endif
    @if(isset($id))
        id="{{ $id}}"
    @endif>
    {{ $text ?? "Button" }}
</button>
