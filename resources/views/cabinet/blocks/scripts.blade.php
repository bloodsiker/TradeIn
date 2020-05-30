
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/dashforge.js') }}"></script>

<script src="{{ asset('lib/js-cookie/js.cookie.js') }}"></script>
{{--<script src="{{ asset('assets/js/dashforge.settings.js') }}"></script>--}}
<script src="{{ asset('assets/js/notify.min.js') }}"></script>

<script>
    $(function(){
        'use strict'

        $('[data-toggle="tooltip"]').tooltip();
    })
</script>

@stack('scripts')
