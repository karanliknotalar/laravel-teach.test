<button type="{{ $type ?? "button" }}" class="{{ $class ?? "btn btn-danger p-1 btnsil mx-1" }}"
        @if($overText ?? false)
            tabindex="0"
        data-bs-placement="{{ $placement ?? "top" }}"
        data-bs-toggle="{{ $toggle ?? "popover" }}"
        data-bs-trigger="{{ $trigger ?? "hover" }}"
        data-bs-content="{{ $message ?? "Mesajınız..." }}"
    @endif
>
    {{ $text ?? "Button" }}
</button>
