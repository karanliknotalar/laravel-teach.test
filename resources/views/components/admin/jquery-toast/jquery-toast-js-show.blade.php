<script src="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.js"></script>
<script>
    function showToast(message, icon, timeout) {
        $.toast({
            text: message,
            icon: icon,
            allowToastClose: false,
            hideAfter: timeout,
            position: 'top-right',
        });
    }
</script>
