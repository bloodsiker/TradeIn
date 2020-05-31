@component('mail::message')
<center><img style="margin-bottom: 20px;" src="https://1kp.by/img/logo1kp.png" /></center>

Создан заказ #{{ $id }}
@component('mail::table')
|                |                |
|----------------|----------------|
| Товар          | {{ $product }} |
| Ссылка         | {{ $link }}    |
| Розничная цена | {{ $retail }}  |
@endcomponent

@component('mail::table')
|                |                         |
|----------------|-------------------------|
| Клиент         | {{ $user->name }}       |
| Email          | {{ $user->email }}      |
| Телефон        | {{ $user->telephone }}  |
@endcomponent

@component('mail::button', ['url' => route('order.update', ['id' => $id])])
Перейти к заказу
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
