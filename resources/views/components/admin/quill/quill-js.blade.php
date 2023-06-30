<!-- quill js -->
<script src="{{ $asset }}vendor/quill/quill.min.js"></script>
<!-- quill init -->
<script>
    jQuery(window).on("load", function () {
        const quill = new Quill("#snow-editor", {
            theme: "snow",
            modules: {toolbar: [[{font: []}, {size: []}], ["bold", "italic", "underline", "strike"], [{color: []}, {background: []}], [{header: [!1, 1, 2, 3, 4, 5, 6]}], ["direction", {align: []}], ["clean"]]}
        });

        const loadquil = function () {
            document.getElementById("{{ $quillHiddenId ?? "quilltext" }}").value = quill.root.innerHTML
        };
        loadquil();
        quill.on('text-change', function (delta, oldDelta, source) {
            loadquil()
        });
    });
</script>
