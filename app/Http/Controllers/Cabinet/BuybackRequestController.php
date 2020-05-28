<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\BuybackBonus;
use App\Models\BuybackRequest;
use App\Models\Status;
use Illuminate\Http\Request;

/**
 * Class BuybackRequestController
 */
class BuybackRequestController extends Controller
{
    public function list()
    {
        $buyRequests = BuybackRequest::all()->sortByDesc('id');
        $statuses = Status::all();

        return view('cabinet.buyback_request.list', compact('buyRequests', 'statuses'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $buyRequest = new BuybackRequest();
            $buyRequest->user_id = \Auth::user()->id;
            $buyRequest->model_id = $request->get('model_id');
            $buyRequest->status_id = Status::STATUS_NEW;
            $buyRequest->name = $request->get('name');
            $buyRequest->email = $request->get('email');
            $buyRequest->phone = $request->get('phone');
            $buyRequest->imei = $request->get('imei');
            $buyRequest->packet = $request->get('packet');
            $buyRequest->cost = (int) $request->get('cost');

            $buyRequest->save();

            return response(['status' => 1, 'type' => 'success', 'message' => 'Ваша заявка на выкуп отправлена!']);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка приотправке заявки']);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $buyRequest = BuybackRequest::find($request->get('id'));
            $buyRequest->user_id = \Auth::user()->id;
            $buyRequest->model_id = $request->get('model_id');
            $buyRequest->status_id = $request->get('status_id');
            $buyRequest->name = $request->get('name');
            $buyRequest->email = $request->get('email');
            $buyRequest->phone = $request->get('phone');
            $buyRequest->imei = $request->get('imei');
            $buyRequest->packet = $request->get('packet');
            $buyRequest->cost = (int) $request->get('cost');

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
