<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\BuybackBonus;
use App\Models\BuybackRequest;
use App\Models\DeviceModel;
use App\Models\DeviceModelRequest;
use App\Models\Network;
use App\Models\Shop;
use Illuminate\Http\Request;

/**
 * Class NetworkController
 */
class AjaxController extends Controller
{
    public function getAjaxData(Request $request)
    {
        switch ($request->get('action')) {
            case 'shop_list':
                $data = Shop::where('network_id', $request->get('network_id'))->get();

                return response(['status' => 1, 'data' => $data]);
            case 'get_network':
                $data = Network::find($request->get('id'));

                return response(['status' => 1, 'data' => $data]);
            case 'get_shop':
                $data = Shop::find($request->get('id'));

                return response(['status' => 1, 'data' => $data]);

            case 'get_model':
                $data = DeviceModel::with('technic')->find($request->get('id'));

                return response(['status' => 1, 'data' => $data]);
            case 'get_request_bonus':
                $data = BuybackBonus::find($request->get('id'));

                return response(['status' => 1, 'data' => $data]);
            case 'get_model_request':
                $data = DeviceModelRequest::with('user')->get()->find($request->get('id'));

                return response(['status' => 1, 'data' => $data]);

            case 'get_buyback_request':
                $data = BuybackRequest::with('user')->with('status')->with('model')->get()->find($request->get('id'));

                return response(['status' => 1, 'data' => $data]);
            default:
                return response(['status' => 0, 'message' => 'Undefined object type']);
        }
    }
}
