<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
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
            default:
                return response(['status' => 0, 'message' => 'Undefined object type']);
        }
    }
}
