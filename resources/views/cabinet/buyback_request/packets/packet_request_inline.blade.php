<li data-id="{{ $buyRequest->id }}" data-packet="{{ $buyPacket->id }}">
    {{ $buyRequest->model->technic->name }} / {{ $buyRequest->model->brand->name }} / {{ $buyRequest->model->name }} / {{ $buyRequest->cost }} грн
    @if(!$buyPacket->ttn)
        <small class="remove-from-ttn"><i class="fa fa-times"></i></small>
    @endif
</li>
