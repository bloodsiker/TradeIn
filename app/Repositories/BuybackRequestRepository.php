<?php

namespace App\Repositories;

use App\Models\BuybackRequest;
use App\Repositories\Interfaces\BuybackRequestRepositoryInterface;

class BuybackRequestRepository implements BuybackRequestRepositoryInterface
{
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
}
