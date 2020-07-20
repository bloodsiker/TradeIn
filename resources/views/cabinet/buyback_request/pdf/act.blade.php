@php
    Date::setLocale('uk')
@endphp

<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Act</title>
    <style>
        body {font-family: DejaVu Sans, sans-serif; font-size: 11px;}
        .container{margin: 0 auto; width: 720px}
        p{margin: 3px}
        .clear{clear: both}
        .mt-10{margin-top: 10px}
        .mt-15{margin-top: 15px}
        .mt-25{margin-top: 25px}
        .pl-10{padding-left: 10px}
        table{width: 100%; border-spacing: 0}
        table tr > td{border: 1px solid #000; padding: 5px}
        table tr > td:last-child{border-left: none}
        .underline{text-decoration: underline}
        .nobr{white-space: nowrap;}
    </style>
</head>
<body>
<div class="container">
    <div class="mt-15" style="text-align: center;font-weight: bold;">
        <p>АКТ</p>
        <p>прийому-передачі старої електронної техніки</p>
    </div>
    <div style="margin-top: 15px">
        <div style="width: 50%; float: left;text-align: left;">
            @if ($buyBackRequest->user->shop)
                <p><span class="underline">м.{{ $buyBackRequest->user->shop->city }}</span></p>
            @else
                <p>м.___________</p>
            @endif
        </div>
        <div style="width: 50%; float: right; text-align: right">
            <p><span class="underline">{{ Date::now()->format('j F Y р') }}</span></p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="mt-15">
        <p>{{ $buyBackRequest->user->network->paragraph_1 }}</p>
        <p class="mt-10">
            {{ $buyBackRequest->user->network->paragraph_2 }} <span class="underline">{{ $buyBackRequest->actForm->fio }}</span>, який мешкає за адресою: <span class="underline">{{ $buyBackRequest->actForm->address }}</span>, посвідчення особи видане (ким, коли) <span class="underline">{{ $buyBackRequest->actForm->serial_number }}</span> <span class="underline">{{ $buyBackRequest->actForm->issued_by }}</span>
        </p>
    </div>
    <div>
        <p>(надалі – Клієнт), з іншого боку, склали даний акт про таке:</p>
        <p class="mt-10">1. Клієнт передає, а Довіритель приймає стару електронну техніку (СЕТ) що належить Клієнту за наступними характеристиками:</p>
        <p class="pl-10">1.1. Найменування <span class="underline">{{ $buyBackRequest->model->technic ? $buyBackRequest->model->technic->name : null }}</span></p>
        <p class="pl-10">1.2. Марка: <span class="underline">{{ $buyBackRequest->model->brand->name }}</span></p>
        <p class="pl-10">1.3. Модель: <span class="underline">{{ $buyBackRequest->model->name }}</span></p>
        <p class="pl-10">1.4. с/н / IMEI: <span class="underline">{{ $buyBackRequest->imei }}</span></p>
        <p class="pl-10">1.5. Комплектація: ___________________________________________________________________________________________________________</p>
        <p class="pl-10">1.6. Працездатність: _________________________________________________________________________________________________________</p>
        <p class="pl-10">1.7. Опис зовнішнього вигляду:_____________________________________________________________________________________________
            _________________________________________________________________________________________________________________________________
            _________________________________________________________________________________________________________________________________
        </p>
        <p class="pl-10">1.8. Інше: _____________________________________________________________________________________________________________________
            _________________________________________________________________________________________________________________________________</p>
        <p>2. Належність техніки клієнту підтверджується: (№, дата, чеку, гар талону, тощо ) : _________________________________________________________________________________________________________________________________</p>
        <p>3. Підписуючи даний акт Клієнт цілком усвідомлює та безумовного погоджується віддати у власність Довірителя свій товар описаний в пункті 1 даного акту та в подальшому відмовляється від претензій до {{ $buyBackRequest->user->network->tov }} або до Довірителя.  </p>
        <p>4. Підписанням даного акту Клієнт підтверджує що він повідомлений про можливість придбати зі знижкою новий пристрій в мережі магазинів
            {{ $buyBackRequest->user->network->shop }}. Оціночна вартість старої електронної техніки, яка здається клієнтом,
            становить: <span class="underline">{{ $buyBackRequest->cost }}</span> грн.</p>
        <p class="pl-10">4.1. Клієнт прибав сертифікат (так/ні) : _____________________________________________________________________________________</p>
        <p>5. Підписанням даного акту клієнт надає згоду на обробку та використання його персональних даних вказаних в даному акті {{ $buyBackRequest->user->network->tov }} та
            Довірителю, з правом доступу до них третіх осіб в разі виникнення такої необхідності. Згода надається на використання персональних даних у
            сфері господарської та маркетингової діяльності та інших не заборонених законодавством України випадках. Права суб’єкта персональних
            даних Клієнту письмово повідомлені. </p>
        <p><b>6. Підписи сторін:</b></p>
    </div>
    <div class="mt-10">
        <table>
            <tr>
                <td width="50%">
                    <p>Довіритель</p>
                    <p>ТОВ «Дженерал Сервісез», від імені якого діє Повірений</p>
                    <br>
                    <p>{{ $buyBackRequest->user->network->tov }} в особі керівника магазину розташованого за адресою:</p>
                    <p class="mt-5">{{ $buyBackRequest->user->shop->address }}</p>
                    <p class="mt-10">______________________ /________________________/</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Підпис &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ПІБ</p>
                </td>
                <td width="50%" style="vertical-align: text-top">
                    <p>Клієнт</p>
                    <p>{{ $buyBackRequest->actForm->fio }}, {{ $buyBackRequest->actForm->address }},
                        {{ $buyBackRequest->actForm->type_document }}: {{ $buyBackRequest->actForm->serial_number }}.
                        {{ $buyBackRequest->actForm->issued_by }}
                    </p>
                    <br>
                    <br>
                    <br>
                    <p></p>
                    <p class="mt-10">______________________ /________________________/</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Підпис &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ПІБ</p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
