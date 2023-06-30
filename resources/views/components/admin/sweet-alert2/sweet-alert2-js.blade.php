<!-- sweetalert2 Init js -->
<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.all.min.js "></script>

@if(isset($useDeleteJs))
    <script>
        <!-- Delete Slider js -->
        $("{{ $selectBtnQuery }}").on("click", function (p) {
            const id = {{ $id }};
            const url = "{{ $destroyRoute }}".replace(":id", id);

            const swal = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swal.fire({
                title: '{{ $messageTitle ?? "Silinsin mi?" }}',
                icon: '{{ $messageİcon ?? "warning" }}',
                showCancelButton: {{ $showCancelBtn ?? true }},
                confirmButtonText: '{{ $confirmBtnText ?? "Ever, Sil" }}',
                cancelButtonText: '{{ $cancelBtnText ?? "Hayır, Silme" }}',
                reverseButtons: {{ isset($reverseBtn) && $reverseBtn ? "true" : "false" }}
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "{{ $postMethod ?? "DELETE" }}",
                        url: url,
                        data: {"_token": "{{ csrf_token() }}",},
                        success: function (response) {
                            if (response.result === true) {
                                swal.fire('{{ $successMsg ?? "Silindi!" }}', '', 'success');
                                setTimeout(function () {
                                    location.reload();
                                }, {{ $pageReloadTimeout ?? 1000 }});
                            } else {
                                swal.fire('{{ $resultFailedMsg ?? "İşlem sırasında hata oluştu" }}', '', 'error');
                            }
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swal.fire('{{ $resultCancelMsg ?? "Silme işlemi iptal edildi" }}', '', 'error')
                }
            });
        });
    </script>
@endif
