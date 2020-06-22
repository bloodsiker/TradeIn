@component('mail::message')
<center><img style="margin-bottom: 20px;" src="http://trade.topbook.com.ua/assets/img/logo/Logo_GS.png" /></center>


@component('mail::panel')
    # Статус заявки #{{ $id }} был обновлен
    Текущий статус "{{ $status }}"
@endcomponent

@component('mail::table')
|                   |                   |
|-------------------|-------------------|
| Производитель     | {{ $brand }}      |
| Модель            | {{ $model }}      |
| IMEI              | {{ $emei }}       |
| Номер сейф-пакета | {{ $packet }}     |
| Стоимость         | {{ $cost }} грн   |
| Дата заявки       | {{ $created_at }} |

@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
