<li data-id="{{ $buyRequest->id }}" data-ttn="{{ $ttnObject->id }}">
    {{ $buyRequest->model->technic->name }} / {{ $buyRequest->model->brand->name }} / {{ $buyRequest->model->name }} / {{ $buyRequest->cost }} грн
    <small class="remove-from-ttn"><i class="fa fa-times"></i></small>
</li>
