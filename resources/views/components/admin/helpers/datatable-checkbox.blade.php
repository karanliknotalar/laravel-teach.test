<div>
    <input type="checkbox" id="{{ $id ?? "" }}"
           data-switch="success"
           {{ $status ? 'checked' : '' }} class="{{ $selectClass }}"/>
    <label for="{{ $id ?? "" }}" data-on-label="On" data-off-label="Off"
           class="mb-0 d-block"></label>
</div>
