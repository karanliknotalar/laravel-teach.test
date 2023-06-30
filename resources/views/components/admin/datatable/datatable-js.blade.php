<!-- Datatables js -->
<script src="{{ $asset }}vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ $asset }}vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ $asset }}vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ $asset }}vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

<script>
    <!-- Datatable Init js -->
    $(document).ready(function () {
        $("#items-datatable").DataTable({
            keys: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            }
        });
    });
</script>
