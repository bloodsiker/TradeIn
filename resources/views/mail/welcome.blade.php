@component('mail::message')
<center><img style="margin-bottom: 20px;" src="https://1kp.by/img/logo1kp.png" /></center>

Добро пожаловать

Спасибо за регистрацию

@if($password)
# Логин
{{ $email }}
# Пароль
{{ $password }}
@endif

@component('mail::button', ['url' => route('user.show')])
Перейти в личный кабинет
@endcomponent

Спасибо!<br>
{{ config('app.name' , '1kp.by') }}
@endcomponent
