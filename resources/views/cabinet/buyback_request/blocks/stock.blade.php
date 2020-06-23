<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content tx-14">
        <div class="modal-header">
            <h6 class="modal-title" id="titleModal">Задолженость cклада</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="accordion" class="accordion accordion-style1">
                @foreach($debtNetworks as $debtNetwork)
                    <h6 class="accordion-title">{{ $debtNetwork->name }} - {{ $debtNetwork->debt }} грн</h6>
                    <div class="accordion-body">

                        @foreach($debtShops as $debtShop)
                            @if ($debtNetwork->id === $debtShop->network_id)
                                <div class="accordion-shop">{{ $debtShop->name }} - <span class="tx-warning">{{ $debtShop->debt }} грн</span></div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
        </div>
    </div>

    <script>
        $(function() {
            'use strict'

            $('#accordion').accordion({
                heightStyle: 'content',
                collapsible: true,
                active: false
            });
        });
    </script>
</div>


