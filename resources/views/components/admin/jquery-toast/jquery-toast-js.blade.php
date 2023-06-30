<script src="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.js"></script>

@if(isset($useToastStatus) && $useToastStatus)
    <script>
        <!-- Switch Status on/off js -->
        function showToast(message, icon, timeout) {
            $.toast({
                text: message,
                icon: icon,
                allowToastClose: false,
                hideAfter: timeout,
                position: 'top-right',
            });
        }

        $("{{ $selectCheckboxQuery ?? ".sliderStatus" }}").on("click", function (p) {

            const id = {{ $id }};
            const url = "{{ $updateRoute }}".replace(":id", id);
            const status = $(this).prop("checked") ? 1 : 0;

            $.ajax({
                method: "{{ $method ?? "PUT" }}",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status
                },
                success: function (response) {
                    response.result
                        ? showToast("{{ $successMsg ?? "İşlem başarılı" }}", "success", {{ $timeOut ?? 1200 }})
                        : showToast("{{ $failedMsg ?? "İşlem başarısız" }}", "error", {{ $timeOut ?? 1200 }});
                }
            });
        });
    </script>
@endif
