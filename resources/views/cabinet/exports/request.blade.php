<table>
    <thead>
    <tr>
        <th>Пользователь</th>
        <th>Производитель</th>
        <th>Модель</th>
        <th>IMEI</th>
        <th>Номер сейф-пакета</th>
        <th>Стоимость (грн)</th>
        <th>Статус</th>
        <th>Бонус</th>
        <th>Дата</th>
    </tr>
    </thead>
    <tbody>
    @foreach($requests as $request)
        <tr>
            <td>{{ $request->user->fullName() }}</td>
            <td>{{ $request->model->brand->name }}</td>
            <td>{{ $request->model->name }}</td>
            <td>{{ $request->imei }}</td>
            <td>{{ $request->packet }}</td>
            <td>{{ $request->cost }}</td>
            <td>{{ $request->status->name }}</td>
            <td>{{ $request->bonus }}</td>
            <td>{{ \Carbon\Carbon::parse($request->created_at)->format('Y-m-d H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
