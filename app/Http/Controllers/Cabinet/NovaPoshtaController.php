<?php

namespace App\Http\Controllers\Cabinet;

use App\Exports\BuybackRequestExport;
use App\Http\Controllers\Controller;
use App\Mail\RequestChangeStatusShipped;
use App\Models\BuybackBonus;
use App\Models\BuybackRequest;
use App\Models\Network;
use App\Models\Role;
use App\Models\Shop;
use App\Models\Status;
use App\Models\User;
use App\Services\NovaPoshtaApi;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

/**
 * Class NovaPoshtaController
 */
class NovaPoshtaController extends Controller
{
    public function list(Request $request)
    {
        $listTtn = [];

        return view('cabinet.nova_poshta.list', compact('listTtn'));
    }

    public function counterparty(Request $request)
    {
        $listTtn = [];

        return view('cabinet.nova_poshta.counterparty', compact('listTtn'));
    }

    public function addCounterparty(Request $request)
    {
        $listTtn = [];

        if ($request->isMethod('post')) {
//            dd($request->get('phone'));
            $np = new NovaPoshtaApi('68cb6099fc69880122b1c572531a7d15');

            $counterparty = $np->model('Counterparty')->save([
                'FirstName' => $request->get('FirstName'),
                'MiddleName' => $request->get('MiddleName'),
                'LastName' => $request->get('LastName'),
                'Phone' => $request->get('phone'),
                'Email' => $request->get('email', ''),
                'CounterpartyType' => 'PrivatePerson',
                'CounterpartyProperty' => 'Recipient',
            ]);

            if ($counterparty['success']) {
                $per = [
                    'ref' => $counterparty['data'][0]['Ref'],
                    'FirstName' => $counterparty['data'][0]['FirstName'],
                    'MiddleName' => $counterparty['data'][0]['MiddleName'],
                    'LastName' => $counterparty['data'][0]['LastName'],
                ];
            }

            dd($counterparty);
        }

        return view('cabinet.nova_poshta.add_counterparty', compact('listTtn'));
    }

    public function addTtn(Request $request)
    {
        $np = new NovaPoshtaApi('68cb6099fc69880122b1c572531a7d15');

//        $senderInfo = $np->getCounterparties('Sender', 1, 'Овсійчук Дмитро Віталійович', 'Київ');
//        $senderInfo = $np->getCounterpartyContactPersons('2819ab78-d46b-11e7-becf-005056881c6b');
//        dump($senderInfo);die;

        $cities = $np->getCities();

        $typeOfPayers = $np->getTypesOfPayers();
        $paymentForms = $np->getPaymentForms();
        $cargoTypes = $np->getCargoTypes();

        if ($request->isXmlHttpRequest() && $request->get('action') === 'getWarehouse') {
            $result = $np->getWarehouses($request->get('city'));
            return response()->json($result);
        }

//        $counterparty = $np->model('Counterparty')->save([
//            'FirstName' => 'Дмитрий',
//            'MiddleName' => 'Витальевич',
//            'LastName' => 'Овсийчук',
//            'Phone' => '0935147288',
//            'Email' => 'maldini2@ukr.net',
//            'CounterpartyType' => 'PrivatePerson',
//            'CounterpartyProperty' => 'Recipient',
//        ]);

        if ($request->isMethod('post')) {
            $this->insertDocument($np, $request);
        }

        return view('cabinet.nova_poshta.add_ttn', compact('cities', 'typeOfPayers', 'paymentForms', 'cargoTypes'));
    }

    private function insertDocument(NovaPoshtaApi $np, Request $request)
    {
//        $senderInfo = $np->getCounterparties('Sender', 1, '', '');
        $senderInfo = $np->getCounterpartyContactPersons('2819ab78-d46b-11e7-becf-005056881c6b');
//        dump($senderInfo);die;
        // Выбор отправителя в конкретном городе (в данном случае - в первом попавшемся)
        $sender = $senderInfo['data'][0];
        // Информация о складе отправителя
//        $senderWarehouses = $np->getWarehouses($sender['City']);

        $result = $np->newInternetDocument(
        // Данные отправителя
            [
                // Данные пользователя
                'Sender' => '2819ab78-d46b-11e7-becf-005056881c6b',
                'ContactSender' => 'c642e7d8-b2f9-11ea-8513-b88303659df5',
                'SendersPhone' => '0935147288',
//                'FirstName' => $sender['FirstName'],
//                'MiddleName' => $sender['MiddleName'],
//                'LastName' => $sender['LastName'],
                // Вместо FirstName, MiddleName, LastName можно ввести зарегистрированные ФИО отправителя или название фирмы для юрлиц
                // (можно получить, вызвав метод getCounterparties('Sender', 1, '', ''))
                // 'Description' => $sender['Description'],
                // Необязательное поле, в случае отсутствия будет использоваться из данных контакта
                // 'Phone' => '0631112233',
                // Город отправления
                // 'City' => 'Белгород-Днестровский',
                // Область отправления
                // 'Region' => 'Одесская',
                'CitySender' => '69da41f3-3f5d-11de-b509-001d92f78698',
//                'CitySender' => $sender['City'],
                // Отделение отправления по ID (в данном случае - в первом попавшемся)
                'SenderAddress' => '16922847-e1c2-11e3-8c4a-0050568002cf',
//                'SenderAddress' => $senderWarehouses['data'][0]['Ref'],
                // Отделение отправления по адресу
                // 'Warehouse' => $senderWarehouses['data'][0]['DescriptionRu'],
            ],
            // Данные получателя
            [
                'FirstName' => $request->get('FirstName'),
                'MiddleName' => $request->get('MiddleName'),
                'LastName' => $request->get('LastName'),
                'Phone' => $request->get('RecipientsPhone'),
                'City' => $request->get('RecipientCityName'),
                'Region' => $request->get('RecipientArea', ''),
                'Warehouse' => $request->get('RecipientAddressName'),
                'CounterpartyType' => 'PrivatePerson',
                'CityRecipient' => $request->get('CityRecipient'),
                'CityRef' => $request->get('CityRecipient'),
                'RecipientAddress' => $request->get('RecipientAddress'),
                'Recipient' => '',
            ],
            [
                // Дата отправления
                'DateTime' => date('d.m.Y'),
                // Тип доставки, дополнительно - getServiceTypes()
                'ServiceType' => 'WarehouseWarehouse',
                // Тип оплаты, дополнительно - getPaymentForms()
                'PaymentMethod' => $request->get('PaymentMethod'),
                // Кто оплачивает за доставку
                'PayerType' => $request->get('PayerType'),
                // Стоимость груза в грн
                'Cost' => $request->get('Cost'),
                // Кол-во мест
                'SeatsAmount' => '1',
                // Описание груза
                'Description' => $request->get('Description'),
                // Тип доставки, дополнительно - getCargoTypes
                'CargoType' => $request->get('CargoType'),
                // Вес груза
                'Weight' => $request->get('Weight'),
                // Объем груза в куб.м.
                'VolumeGeneral' => $request->get('VolumeGeneral'),
                // Обратная доставка
//                'BackwardDeliveryData' => [
//                    [
//                        // Кто оплачивает обратную доставку
//                        'PayerType' => 'Recipient',
//                        // Тип доставки
//                        'CargoType' => 'Money',
//                        // Значение обратной доставки
//                        'RedeliveryString' => 4552,
//                    ]
//                ]
            ]
        );

        dump($result);die;
    }
}
