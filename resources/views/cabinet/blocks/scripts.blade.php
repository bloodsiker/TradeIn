
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('assets/js/dashforge.js') }}"></script>

<script src="{{ asset('lib/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('assets/js/dashforge.settings.js') }}"></script>

@stack('scripts')

<script>
    $(function(){
        'use strict'

        $('[data-toggle="tooltip"]').tooltip()

        // Sidebar calendar
        $('#calendarInline').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            beforeShowDay: function(date) {

                // add leading zero to single digit date
                var day = date.getDate();
                console.log(day);
                return [true, (day < 10 ? 'zero' : '')];
            }
        });
    })
</script>
