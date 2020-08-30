<script type='text/javascript'>
    $(function ($) {
        let url = window.location.href;
        $('div a').each(function () {
            if (this.href === url) {
                $(this).closest('a').addClass('active');
            }
        });
    });
</script>