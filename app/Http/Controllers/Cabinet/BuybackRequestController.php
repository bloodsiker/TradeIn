<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\BuybackBonus;
use App\Models\BuybackRequest;
use App\Models\Network;
use App\Models\Shop;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class BuybackRequestController
 */
class BuybackRequestController extends Controller
{
    public function list(Request $request)
    {
        $statuses = Status::all();
        $shops = $networks = [];
        $query = BuybackRequest::with('user');
        $query->join('users', 'users.id', '=', 'buyback_requests.user_id');

        if (\Auth::user()->isAdmin()) {
            $networks = Network::all();
            $shops = Shop::all();

        } elseif (\Auth::user()->isShop()) {
            $query->where('user_id', \Auth::user()->id);
        }

        if ($request->has('network_id') && $request->get('network_id')) {
            $query->join('networks', 'users.network_id', '=', 'networks.id')
                ->where('networks.id', $request->get('network_id'));
        }

        if ($request->has('shop_id') && $request->get('shop_id')) {
            $query->join('shops', 'users.shop_id', '=', 'shops.id')
                ->where('shops.id', $request->get('shop_id'));
        }

        if ($request->get('date_from') && $request->get('date_to')) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::parse($request->get('date_to'))->format('Y-m-d').' 23:59';
            $query->whereBetween('.buyback_requests.created_at', [$from, $to]);
        } elseif ($request->get('date_from') && empty($request->get('date_to'))) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::now()->format('Y-m-d').' 23:59';
            $query->whereBetween('buyback_requests.created_at', [$from, $to]);
        }

        if ($request->has('status_id') && $request->get('status_id')) {
            $query->where('status_id', $request->get('status_id'));
        }

        $buyRequests = $query->select('buyback_requests.*')->get()->sortByDesc('id');

        return view('cabinet.buyback_request.list', compact('buyRequests', 'statuses', 'shops', 'networks'));
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
        if ($request->isMethod('post') && $request->filled('id')) {

            $buyRequest = BuybackRequest::find($request->get('id'));
            $buyRequest->status_id = $request->get('status_id');
            $buyRequest->imei = $request->get('imei');
            $buyRequest->packet = $request->get('packet');

            $buyRequest->save();
            $buyRequest->load('user', 'status', 'model');

            return response(['status' => 1, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $buyRequest]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function delete(Request $request)
    {
        $bonus = BuybackRequest::findOrFail($request->get('id'));

        if ($bonus) {
            $bonus->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Заявка удалена!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
