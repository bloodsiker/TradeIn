<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\BuybackBonus;
use App\Models\BuybackRequest;
use Illuminate\Http\Request;

/**
 * Class BuybackRequestController
 */
class BuybackRequestController extends Controller
{
    public function list()
    {
        $buyRequests = BuybackRequest::all();

        return view('cabinet.buyback_request.list', compact('buyRequests'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $buyRequest = new BuybackRequest();
            $buyRequest->user_id = \Auth::user()->id;
            $buyRequest->name = $request->get('name');
            $buyRequest->email = $request->get('email');
            $buyRequest->phone = $request->get('phone');
            $buyRequest->imei = $request->get('imei');
            $buyRequest->packet = $request->get('packet');
            $buyRequest->cost = (int) $request->get('cost');

            $buyRequest->save();

            return redirect()->route('cabinet.buyback_bonus.list')->with('success', "Правило для бонуса добавлено!");
        }

        return redirect()->route('cabinet.buyback_bonus.list')->with('danger', 'Ошибка, правило для бонуса не удалось добавить!');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $bonus = BuybackBonus::find($request->get('id'));
            $bonus->cost_from = $request->get('cost_from');
            $bonus->cost_to = $request->get('cost_to');
            $bonus->bonus = $request->get('bonus');
            $bonus->save();

            return redirect()->route('cabinet.buyback_bonus.list')->with('success', 'Информация обновлена');
        }

        return redirect()->route('cabinet.buyback_bonus.list')->with('danger', 'Ошибка при обновлении!');
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
