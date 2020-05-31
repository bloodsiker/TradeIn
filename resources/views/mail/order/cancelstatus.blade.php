@component('mail::message')
<center><img style="margin-bottom: 20px;" src="https://1kp.by/img/logo1kp.png" /></center>

Статус заказа #{{ $id }} был обновлен

Текущий статус заказа "{{ $status }}"

@component('mail::table')
|                |                |
|----------------|----------------|
| Товар          | {{ $product }} |
| Ссылка         | {{ $link }}    |
| Розничная цена | {{ $retail }}  |
@if($price)
| Цена           | {{ $price }}   |
@endif
@endcomponent

@component('mail::button', ['url' => route('order.update', ['id' => $id])])
Перейти
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
