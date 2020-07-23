<?php

namespace App\Http\Controllers\Cabinet;

use App\Exports\BuybackRequestExport;
use App\Facades\UserLog;
use App\Http\Controllers\Controller;
use App\Mail\RequestChangeStatusShipped;
use App\Models\BuybackBonus;
use App\Models\BuybackPacket;
use App\Models\BuybackRequest;
use App\Models\Network;
use App\Models\NovaPoshta;
use App\Models\NovaPoshtaCounterparty;
use App\Models\NovaPoshtaCounterpartyPerson;
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
        $query = NovaPoshta::select('nova_poshtas.*')
            ->join('users', 'users.id', '=', 'nova_poshtas.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id');

        if (\Auth::user()->isNetwork()) {
            $query->where('networks.id', \Auth::user()->network_id);
        }

        if (\Auth::user()->isShop()) {
            $query->where('shops.id', \Auth::user()->shop_id);
        }

        $listTtn = $query->orderBy('id', 'DESC')->get();

        return view('cabinet.nova_poshta.list', compact('listTtn'));
    }

    public function ttn(Request $request, $ttn)
    {
        $ttnObject = NovaPoshta::where('ttn', $ttn)->first();

//        $np = new NovaPoshtaApi(\Auth::user()->nova_poshta_key);
//        $result = $np->documentsTracking($ttnObject->ttn);

        return view('cabinet.nova_poshta.ttn', compact('ttnObject'));
    }

    public function addToTtn(Request $request)
    {
        $ttnObject = NovaPoshta::find($request->get('ttn'));

        $buyRequest = BuybackRequest::find($request->get('id'));

        if ($request->get('action') === 'addToTtn') {
            $ttnObject->requests()->attach($buyRequest);
            return view('cabinet.nova_poshta.blocks.ttn_request_inline', compact('buyRequest', 'ttnObject'));

        } elseif ($request->get('action') === 'removeFromTtn') {
            $ttnObject->requests()->detach($buyRequest);
            $buyRequest->load('user', 'model', 'status');

            return view('cabinet.nova_poshta.blocks.ttn_request_row', compact('buyRequest', 'ttnObject'));
        }

        return response(['status' => 1, 'type' => 'success', 'message' => "Добавленно к посылке!", 'data' => $data ?? null]);
    }

    public function addTtn(Request $request)
    {
        $cities = $typeOfPayers = $paymentForms = $cargoTypes = [];
        $senderContact =  $recipientContact = [];
        $packets = BuybackPacket::all();

        if (\Auth::user()->nova_poshta_key) {
//        $vika = '364362610047bf3f07e7d65b0a4e9844';
            $np = new NovaPoshtaApi(\Auth::user()->nova_poshta_key);

            $senderInfo = $np->getCounterparties('Sender', 1);
            $senderContact = $np->getCounterpartyContactPersons($senderInfo['data'][0]['Ref']);
            $recipientInfo = $np->getCounterparties('Recipient', 1);
            $recipientContact = $np->getCounterpartyContactPersons($recipientInfo['data'][0]['Ref']);

            $cities = $np->getCities();

            $typeOfPayers = $np->getTypesOfPayers();
            $paymentForms = $np->getPaymentForms();
            $cargoTypes = $np->getCargoTypes();

            if ($request->isXmlHttpRequest() && $request->get('action') === 'getWarehouse') {
                $result = $np->getWarehouses($request->get('city'));
                return response()->json($result);
            }

            if ($request->isMethod('post')) {
                $ttn = $this->insertDocument($np, $request);

                return redirect()->route('cabinet.nova_poshta.ttn' , ['ttn' => $ttn->ttn]);
            }
        }

        return view('cabinet.nova_poshta.add_ttn',
            compact('cities', 'typeOfPayers', 'paymentForms', 'cargoTypes', 'senderContact', 'recipientContact', 'packets'));
    }

    public function deleteTtn(Request $request, $ttn)
    {
        if (\Auth::user()->nova_poshta_key) {
            $np = new NovaPoshtaApi(\Auth::user()->nova_poshta_key);
            $ttn = NovaPoshta::where('ttn', $ttn)->first();

            if ($ttn) {
                $deleteTtn = $np->model('InternetDocument')->delete([
                    'DocumentRefs' => [$ttn->ref],
                ]);

                if ($deleteTtn['success']) {
                    $ttn->delete();

                    UserLog::log("Удалил экспресс-накладную  ТТН {$ttn->ttn}");

                    return redirect()->route('cabinet.nova_poshta.list')->with('success', 'Экспресс-накладная удалена!');
                }

                return redirect()->route('cabinet.nova_poshta.list')->with('error', 'Не удалось удалить экспресс-накладную');
            }

            return redirect()->route('cabinet.nova_poshta.list')->with('error', 'Экспресс-накладная не найдена!');
        }

        return redirect()->route('cabinet.nova_poshta.list')->with('error', 'Не удалось удалить экспресс-накладную');
    }

    private function insertDocument(NovaPoshtaApi $np, Request $request)
    {
        $senderInfo = $np->getCounterparties('Sender', 1);
        $senderContact = $np->getCounterpartyContactPersons($senderInfo['data'][0]['Ref']);

        if ($request->get('ServiceType') == 'WarehouseWarehouse') {
            $address = $request->get('RecipientAddressName');
        } elseif ($request->get('ServiceType') == 'WarehouseDoors') {
            $address = $request->get('RecipientStreetName');
        }

        $result = $np->newInternetDocument2(
            [
                "NewAddress" => "1",
                "PayerType" => $request->get('PayerType'),
                "PaymentMethod" => $request->get('PaymentMethod'),
                "CargoType" => $request->get('CargoType'),
                "VolumeGeneral" => $request->get('VolumeGeneral'),
                "Weight" => $request->get('Weight'),
                "ServiceType" => $request->get('ServiceType'),
                "SeatsAmount" => "1",
                "Description" => $request->get('Description'),
                "Cost" => $request->get('Cost'),

                "CitySender" => $request->get('CitySender'),
//                "CitySender" => '8d5a980d-391c-11dd-90d9-001a92567626',
//                "Sender" => $request->get('ContactSender'),
                "Sender" => $senderInfo['data'][0]['Ref'],
                "SenderAddress" => $request->get('SenderAddress'),
//                "SenderAddress" => '0d545ece-e1c2-11e3-8c4a-0050568002cf',
//                "ContactSender" => $request->get('ContactSender'),
                "ContactSender" => $senderContact['data'][0]['Ref'],
                "SendersPhone" => $senderContact['data'][0]['Phones'],

                "RecipientCityName" => $request->get('CityRecipient'), //Киев
//                "RecipientCityName" => 'Малин', //Киев
                "RecipientArea" => "",
                "RecipientAreaRegions" => "",
                "RecipientAddressName" => $address ?? '', //Склад
//                "RecipientAddressName" => '3', //Склад
                "RecipientHouse" => $request->get('RecipientHouse'),
                "RecipientFlat" => $request->get('RecipientFlat'),
                "RecipientName" => "{$request->get('LastName')} {$request->get('FirstName')} {$request->get('MiddleName')}",
                "RecipientType" => "PrivatePerson",
                "RecipientsPhone" => $request->get('RecipientsPhone'),
                "DateTime" => date('d.m.Y')
            ]
        );

        if ($result['success']) {
            $ttn = new NovaPoshta();
            $ttn->user_id = \Auth::id();
            $ttn->packet_id = $request->get('packet_id');
            $ttn->sender = $senderContact['data'][0]['Description'];
            $ttn->sender_phone = $senderContact['data'][0]['Phones'];
            $ttn->recipient = "{$request->get('LastName')} {$request->get('FirstName')} {$request->get('MiddleName')}";
            $ttn->recipient_phone = $request->get('RecipientsPhone');
            $ttn->description = $request->get('Description');
            $ttn->ttn = $result['data'][0]['IntDocNumber'];
            $ttn->ref = $result['data'][0]['Ref'];
            $ttn->cost = $result['data'][0]['CostOnSite'];
            $ttn->date_delivery = Carbon::parse($result['data'][0]['EstimatedDeliveryDate'])->format('Y-m-d');
            $ttn->save();

            UserLog::log("Создал экспресс-накладную  ТТН {$ttn->ttn}");

            return $ttn;
        }
    }

    public function packetDescription(Request $request)
    {
//        $packet = BuybackPacket::find($request->get('id'));
//        if ($packet && $packet->requests->count()) {
//            $description = 'Устройства: ';
//            foreach ($packet->requests as $bRequest) {
//                $description .= sprintf('%s %s %s, ', $bRequest->model->technic->name, $bRequest->model->brand->name, $bRequest->model->name);
//            }
//
//            return $description;
//        }

        return null;
    }
}
