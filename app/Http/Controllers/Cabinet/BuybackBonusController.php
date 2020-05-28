<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\BuybackBonus;
use Illuminate\Http\Request;

/**
 * Class BuybackBonusController
 */
class BuybackBonusController extends Controller
{
    public function list()
    {
        $bonuses = BuybackBonus::all();

        return view('cabinet.buyback_bonus.list', compact('bonuses'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'cost_from' => ['required'],
                'cost_to' => ['required'],
                'bonus' => ['required'],
            ]);

            $bonus = new BuybackBonus();
            $bonus->cost_from = $request->get('cost_from');
            $bonus->cost_to = $request->get('cost_to');
            $bonus->bonus = $request->get('bonus');
            $bonus->save();

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

            return response(['status' => 1, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $bonus]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function delete(Request $request)
    {
        $bonus = BuybackBonus::findOrFail($request->get('id'));

        if ($bonus) {
            $bonus->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Правило для бонуса удалено!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
