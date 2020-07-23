<tr data-id="{{ $buyRequest->id }}" data-packet="{{ $buyPacket->id }}">
    <td>{{ $buyRequest->id }}</td>
    <td>{{ $buyRequest->user->fullName() }}</td>
    <td>
        @if( $buyRequest->model)
            <small><b>Тип:</b> {{ $buyRequest->model->technic ? $buyRequest->model->technic->name : null }}</small>
            <br>
            <small><b>Производитель:</b> {{ $buyRequest->model->brand->name }}</small>
            <br>
            <small><b>Модель:</b> {{ $buyRequest->model->name }}</small>
        @endif
    </td>
    <td class="td-imei">{{ $buyRequest->imei }}</td>
    <td class="td-packet">{{ $buyRequest->packet }}</td>
    <td class="td-cost">{{ $buyRequest->cost }}</td>
    <td class="td-status">{{ $buyRequest->status->name }}</td>
    <td><small>{{ \Carbon\Carbon::parse($buyRequest->created_at)->format('d.m.Y H:i') }}</small></td>
    <td>
        <a href="#" class="btn btn-xxs btn-dark btn-icon addToTtn">
            <i class="fas fa-plus"></i>
        </a>
    </td>
</tr>
