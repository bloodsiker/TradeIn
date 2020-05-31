@component('mail::message')
<center><img style="margin-bottom: 20px;" src="http://trade.topbook.com.ua/assets/img/logo/Logo_GS.png" /></center>

@component('mail::panel')
Перейдите по ссылке и дважды введите новый пароль. Нажмите Изменить пароль.
@endcomponent

@component('mail::button', ['url' => $url])
Сбросить пароль
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
