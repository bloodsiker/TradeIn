@component('mail::message')
<center><img style="margin-bottom: 20px;" src="http://trade.topbook.com.ua/assets/img/logo/Logo_GS.png" /></center>


@component('mail::panel')
    Форма обраной связи
@endcomponent

@component('mail::table')
|                   |                   |
|-------------------|-------------------|
| Имя               | {{ $name }}       |
| Email             | {{ $email }}      |
| Телефон           | {{ $phone }}      |
| Сообщение         | {{ $message }}    |

@endcomponent

@endcomponent
