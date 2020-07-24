<?php

namespace App\Repositories;

use App\Models\BuybackBonus;
use App\Models\BuybackRequest;
use App\Models\BuybackRequestActForm;
use App\Models\Status;
use App\Repositories\Interfaces\BuybackRequestRepositoryInterface;
use Illuminate\Http\Request;

class BuybackRequestRepository implements BuybackRequestRepositoryInterface
{
    public function get($id)
    {
        return BuybackRequest::find($id);
    }

    public function baseQuery()
    {
         $query = BuybackRequest::select('buyback_requests.*')->with('status')
            ->join('users', 'users.id', '=', 'buyback_requests.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id');

         return $query;
    }

    public function filterStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    public function byUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function filterShop($query, $shopId)
    {
        return $query->where('shops.id', $shopId);
    }

    public function filterNetwork($query, $shopId)
    {
        return $query->where('networks.id', $shopId);
    }

    public function filterByDate($query, $from, $to)
    {
        return $query->whereBetween('buyback_requests.created_at', [$from, $to]);
    }

    /**
     * @param Request $request
     *
     * @return BuybackRequest|mixed
     */
    public function add(Request $request)
    {
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

        $actForm = new BuybackRequestActForm();
        $actForm->fio = $request->get('fio');
        $actForm->address = $request->get('address');
        $actForm->type_document = $request->get('type_document');
        $actForm->serial_number = $request->get('serial_number');
        $actForm->issued_by = $request->get('issued_by');
        $actForm->request()->associate($buyRequest);

        $actForm->save();

        return $buyRequest;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $buyRequest = BuybackRequest::find($request->get('id'));

        if (!$buyRequest->is_accrued && $request->get('status_id') == Status::STATUS_TAKE) {
            $buyRequest->is_accrued = true;
        }

        if ($request->filled('status_id')) {
            $buyRequest->status_id = $request->get('status_id');
        }

        $buyRequest->imei = $request->get('imei');
        $buyRequest->packet = $request->get('packet');

        $buyRequest->save();

        $act = $buyRequest->actForm;
        $act->fio = $request->get('fio');
        $act->address = $request->get('address');
        $act->serial_number = $request->get('serial_number');
        $act->issued_by = $request->get('issued_by');
        $act->save();

        return $buyRequest;
    }
}
