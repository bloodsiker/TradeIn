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
use Carbon\Carbon;
use DB;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use LisDev\Delivery\NovaPoshtaApi2;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

/**
 * Class BuybackRequestController
 */
class BuybackRequestController extends Controller
{
    public function list(Request $request)
    {
        $statuses = Status::all();
        $allowStatuses = [];
        $shops = $networks = $users = [];
        $query = BuybackRequest::select('buyback_requests.*')->with('status');
        $query->join('users', 'users.id', '=', 'buyback_requests.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id');

        if (\Auth::user()->isAdmin()) {
            $networks = Network::all();
            $shops = Shop::all();
            $allowStatuses = [Status::STATUS_TAKE, Status::STATUS_RETURN, Status::STATUS_SENT];
        }

        if (\Auth::user()->isNetwork()) {
            $allowStatuses = [Status::STATUS_NEW, Status::STATUS_SENT];
            $users = User::where('network_id', \Auth::user()->network_id)->get();
            $shops = Shop::where('network_id', \Auth::user()->network_id)->get();

            $allowShop = $shops->contains(function ($value, $key) use ($request) {
                return $value->id === (int) $request->get('shop_id');
            });

            if ($request->get('shop_id') && !$allowShop) {
                return redirect()->route('cabinet.buyback_request.list')
                    ->with('danger', 'Вы не можете просматривать заявки пользователей которые не находятся в вашей торговой сети!');
            }

            $query->where('networks.id', \Auth::user()->network_id);
        }

        if (\Auth::user()->isShop()) {
            $allowStatuses = [Status::STATUS_NEW, Status::STATUS_SENT];
            $users = User::where('shop_id', \Auth::user()->shop_id)->get();
            $query->where('shops.id', \Auth::user()->shop_id);
        }

        if (!\Auth::user()->isShop()) {
            if ($request->get('network_id')) {
                $query->where('networks.id', $request->get('network_id'));
            }

            if ($request->get('shop_id')) {
                $query->where('shops.id', $request->get('shop_id'));
            }
        }

        if ($request->get('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->get('date_from') && $request->get('date_to')) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::parse($request->get('date_to'))->format('Y-m-d').' 23:59';
            $query->whereBetween('buyback_requests.created_at', [$from, $to]);
        } elseif ($request->get('date_from') && empty($request->get('date_to'))) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::now()->format('Y-m-d').' 23:59';
            $query->whereBetween('buyback_requests.created_at', [$from, $to]);
        }

        if ($request->get('status_id')) {
            $query->where('status_id', $request->get('status_id'));
        }

        $buyRequests = $query->orderBy('id', 'DESC')->get();

        return view('cabinet.buyback_request.list',
            compact('buyRequests', 'statuses', 'shops', 'networks', 'users', 'allowStatuses'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $buyRequest = new BuybackRequest();
            $buyRequest->user_id = \Auth::user()->id;
            $buyRequest->model_id = $request->get('model_id');
            $buyRequest->imei = $request->get('imei');
            $buyRequest->packet = $request->get('packet');
            $buyRequest->cost = (int) $request->get('cost');

            $bonuses = BuybackBonus::all();
            $bonusAdd = 0;
            foreach ($bonuses as $bonus) {
                if ($buyRequest->cost >= $bonus->cost_from && $buyRequest->cost < $bonus->cost_to) {
                    $bonusAdd = $bonus->bonus;
                }
            }

            $buyRequest->bonus = $bonusAdd;

            $buyRequest->save();

            return response(['status' => 1, 'type' => 'success', 'message' => 'Ваша заявка на выкуп отправлена!']);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка приотправке заявки']);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->get('id')) {

            $buyRequest = BuybackRequest::find($request->get('id'));

            if (!$buyRequest->is_accrued && $request->get('status_id') == Status::STATUS_TAKE) {
                $buyRequest->is_accrued = true;
            }

            $buyRequest->status_id = $request->get('status_id');
            $buyRequest->imei = $request->get('imei');
            $buyRequest->packet = $request->get('packet');

            $buyRequest->save();
            $buyRequest->load('user', 'status', 'model');

            if ($buyRequest->wasChanged('status_id') && $buyRequest->status_id == Status::STATUS_SENT) {
                $admins = User::where('role_id', Role::ROLE_ADMIN)->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)
                        ->send(new RequestChangeStatusShipped($buyRequest));
                }
            }

            if ($buyRequest->wasChanged('status_id') && ($buyRequest->status_id == Status::STATUS_TAKE || $buyRequest->status_id == Status::STATUS_RETURN)) {
                Mail::to($buyRequest->user->email)
                    ->send(new RequestChangeStatusShipped($buyRequest));

            }

            $btnPay = (int) $request->get('status_id') === Status::STATUS_TAKE ? 1 : 0;

            return response(['status' => 1, 'btn_pay' => $btnPay, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $buyRequest]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function paid(Request $request)
    {
        $buyRequest = BuybackRequest::find($request->get('id'));

        if ($buyRequest) {
            if (!$buyRequest->is_paid && $buyRequest->is_accrued) {
                $buyRequest->is_paid = true;
                $buyRequest->paid_by = \Auth::id();
                $buyRequest->paid_at = Carbon::now();
            }

            $buyRequest->save();

            return response(['status' => 1, 'type' => 'success', 'message' => "Бонус по заявке выплачен в размере {$buyRequest->bonus} грн!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка, бонус не выплачен!']);
    }

    public function delete(Request $request)
    {
        $buyRequest = BuybackRequest::find($request->get('id'));

        if ($buyRequest) {
            $buyRequest->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Заявка удалена!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }

    public function export(Request $request)
    {
        return Excel::download(
            new BuybackRequestExport($request),
            sprintf('requests %s.xlsx', Carbon::now()->format('Y-m-d H:i'))
        );
    }

    public function pdf(Request $request, $id)
    {
//        $pdf = PDF::loadView('cabinet.buyback_request.pdf.act');
//        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return view('cabinet.buyback_request.pdf.act');
//        return $pdf->download(sprintf('Акт %s.pdf', Carbon::now()->format('d.m.Y H:i')));
    }

    public function loadStock(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $debtNetworks = DB::table('buyback_requests')->select('networks.*')
                ->selectRaw('SUM(buyback_requests.cost) as debt')
                ->join('users', 'users.id', '=', 'buyback_requests.user_id')
                ->join('networks', 'networks.id', '=', 'users.network_id')
                ->where('buyback_requests.status_id', Status::STATUS_NEW)
                ->groupBy('networks.id')->get();

            $debtShops = DB::table('buyback_requests')->select('shops.*')
                ->selectRaw('SUM(buyback_requests.cost) as debt')
                ->join('users', 'users.id', '=', 'buyback_requests.user_id')
                ->leftJoin('shops', 'shops.id', '=', 'users.shop_id')
                ->where('buyback_requests.status_id', Status::STATUS_NEW)
                ->where('shops.id', '<>', null)
                ->groupBy('shops.id')->get();

            return view('cabinet.buyback_request.blocks.stock', compact('debtNetworks', 'debtShops'));
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка, бонус не выплачен!']);
    }

    public function test(Request $request)
    {
        $np = new NovaPoshtaApi2('68cb6099fc69880122b1c572531a7d15');

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

        $senderInfo = $np->getCounterparties('Sender', 1, '', '');
//        $senderInfo = $np->getCounterpartyContactPersons('2819ab78-d46b-11e7-becf-005056881c6b');
//        dump($senderInfo);die;

//        $senderInfo = $np->getCounterparties('Sender', 1, 'c642e7d8-b2f9-11ea-8513-b88303659df5', '');

        if ($request->isMethod('post')) {
            $this->insertDocument($np, $request);
        }

        return view('cabinet.buyback_request.test', compact('cities', 'typeOfPayers', 'paymentForms', 'cargoTypes'));
    }

    private function insertDocument(NovaPoshtaApi2 $np, Request $request)
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
                'CounterpartyType' => '',
                'CityRecipient' => '',
                'RecipientAddress' => '',
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
