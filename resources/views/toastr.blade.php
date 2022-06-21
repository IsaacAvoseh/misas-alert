<script>
    // success message popup notification
    @if(Session::has('message'))
    toastr.success("{{ Session::get('message') }}");
    @endif

    // info message popup notification
    @if(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");
    @endif

    // warning message popup notification
    @if(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");
    @endif

    // error message popup notification
    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif
</script>