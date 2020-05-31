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

@component('mail::button', ['url' => route('user.show')])
Перейти в личный кабинет
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
