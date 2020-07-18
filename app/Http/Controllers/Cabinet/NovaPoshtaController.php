<?php

namespace App\Http\Controllers\Cabinet;

use App\Exports\BuybackRequestExport;
use App\Http\Controllers\Controller;
use App\Mail\RequestChangeStatusShipped;
use App\Models\BuybackBonus;
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
        $listTtn = NovaPoshta::all();

        return view('cabinet.nova_poshta.list', compact('listTtn'));
    }

    public function ttn(Request $request, $ttn)
    {
        $ttnObject = NovaPoshta::where('ttn', $ttn)->first();

//        $np = new NovaPoshtaApi(\Auth::user()->nova_poshta_key);
//        $result = $np->documentsTracking($ttnObject->ttn);

        $query = BuybackRequest::select('buyback_requests.*')->with('status');
        $query->join('users', 'users.id', '=', 'buyback_requests.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id')
            ->leftJoin('nova_poshta_requests', 'nova_poshta_requests.request_id', '=', 'buyback_requests.id')
            ->where('nova_poshta_requests.np_id', '=', null);

        if (\Auth::user()->isNetwork()) {
            $query->where('networks.id', \Auth::user()->network_id);
        }

        if (\Auth::user()->isShop()) {
            $query->where('shops.id', \Auth::user()->shop_id);
        }

        $buyRequests = $query->where('buyback_requests.is_deleted', false)->orderBy('id', 'DESC')->get();

        return view('cabinet.nova_poshta.ttn', compact('ttnObject', 'buyRequests'));
    }

    public function addToTtn(Request $request)
    {
        $ttnObject = NovaPoshta::find($request->get('ttn'))->first();

        $buyRequest = BuybackRequest::find($request->get('id'));

        $ttnObject->requests()->attach($buyRequest);
        $data = $buyRequest->model->technic->name . ' / ' . $buyRequest->model->brand->name . ' / ' . $buyRequest->model->name;

        return response(['status' => 1, 'type' => 'success', 'message' => "Добавленно к посылке!", 'data' => $data]);

//        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка, не удалось добавить!']);
    }

    public function addTtn(Request $request)
    {
        $cities = $typeOfPayers = $paymentForms = $cargoTypes = [];
        $senderContact =  $recipientContact = [];

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
                $this->insertDocument($np, $request);

                return redirect()->route('cabinet.nova_poshta.list');
            }
        }

        return view('cabinet.nova_poshta.add_ttn',
            compact('cities', 'typeOfPayers', 'paymentForms', 'cargoTypes', 'senderContact', 'recipientContact'));
    }

    private function insertDocument(NovaPoshtaApi $np, Request $request)
    {
        $senderInfo = $np->getCounterparties('Sender', 1);
        $senderContact = $np->getCounterpartyContactPersons($senderInfo['data'][0]['Ref']);

        $result = $np->newInternetDocument2(
            [
                "NewAddress" => "1",
                "PayerType" => $request->get('PayerType'),
                "PaymentMethod" => $request->get('PaymentMethod'),
                "CargoType" => $request->get('CargoType'),
                "VolumeGeneral" => $request->get('VolumeGeneral'),
                "Weight" => $request->get('Weight'),
                "ServiceType" => "WarehouseWarehouse",
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
                "RecipientAddressName" => $request->get('RecipientAddressName'), //Склад
//                "RecipientAddressName" => '3', //Склад
                "RecipientHouse" => "",
                "RecipientFlat" => "",
                "RecipientName" => "{$request->get('LastName')} {$request->get('FirstName')} {$request->get('MiddleName')}",
                "RecipientType" => "PrivatePerson",
                "RecipientsPhone" => $request->get('RecipientsPhone'),
                "DateTime" => date('d.m.Y')
            ]
        );

        if ($result['success']) {
            $ttn = new NovaPoshta();
            $ttn->user_id = \Auth::id();
            $ttn->ttn = $result['data'][0]['IntDocNumber'];
            $ttn->ref = $result['data'][0]['Ref'];
            $ttn->cost = $result['data'][0]['CostOnSite'];
            $ttn->date_delivery = $result['data'][0]['EstimatedDeliveryDate'];
            $ttn->save();
        }
    }
}
