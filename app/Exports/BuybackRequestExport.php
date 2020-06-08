<?php

namespace App\Exports;

use App\Models\BuybackRequest;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class BuybackRequestExport implements FromView
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request =  $this->request;

        $query = BuybackRequest::select('buyback_requests.*');
        $query->join('users', 'users.id', '=', 'buyback_requests.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id');

        if (\Auth::user()->isNetwork()) {
            $query->where('networks.id', \Auth::user()->network_id);
        }

        if (\Auth::user()->isShop()) {
            $query->where('shops.id', \Auth::user()->shop_id);
        }

        if ($request->has('network_id') && $request->get('network_id')) {
            $query->where('networks.id', $request->get('network_id'));
        }

        if ($request->has('shop_id') && $request->get('shop_id')) {
            $query->where('shops.id', $request->get('shop_id'));
        }

        if ($request->has('user_id') && $request->get('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->get('date_from') && $request->get('date_to')) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::parse($request->get('date_to'))->format('Y-m-d').' 23:59';
            $query->whereBetween('buyback_requests.created_at', [$from, $to]);
        } elseif ($request->get('date_from') && empty($request->get('date_to'))) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::now()->format('Y-m-d').' 23:59';
            $query->whereBetween('buyback_requests.created_at', [$from, $to]);
        }

        if ($request->has('status_id') && $request->get('status_id')) {
            $query->where('status_id', $request->get('status_id'));
        }

        $requests = $query->orderBy('id', 'DESC')->get();

        return view('cabinet.exports.request', compact('requests'));
    }
}
