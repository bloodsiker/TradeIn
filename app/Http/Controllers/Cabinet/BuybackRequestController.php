<?php

namespace App\Http\Controllers\Cabinet;

use App\Exports\BuybackRequestExport;
use App\Http\Controllers\Controller;
use App\Mail\RequestChangeStatusShipped;
use App\Models\BuybackBonus;
use App\Models\BuybackRequest;
use App\Models\Network;
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
 * Class BuybackRequestController
 */
class BuybackRequestController extends Controller
{
    public function list(Request $request)
    {
        $statuses = Status::all();
        $allowStatuses = [];
        $shops = $networks = $users = [];
        $query = BuybackRequest::select('buyback_requests.*')->with('status');
        $query->join('users', 'users.id', '=', 'buyback_requests.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id');

        if (\Auth::user()->isAdmin()) {
            $networks = Network::all();
            $shops = Shop::all();
            $allowStatuses = [Status::STATUS_TAKE, Status::STATUS_RETURN, Status::STATUS_SENT];
        }

        if (\Auth::user()->isNetwork()) {
            $allowStatuses = [Status::STATUS_NEW, Status::STATUS_SENT];
            $users = User::where('network_id', \Auth::user()->network_id)->get();
            $shops = Shop::where('network_id', \Auth::user()->network_id)->get();

            $allowShop = $shops->contains(function ($value, $key) use ($request) {
                return $value->id === (int) $request->get('shop_id');
            });

            if ($request->get('shop_id') && !$allowShop) {
                return redirect()->route('cabinet.buyback_request.list')
                    ->with('danger', 'Вы не можете просматривать заявки пользователей которые не находятся в вашей торговой сети!');
            }

            $query->where('networks.id', \Auth::user()->network_id);
        }

        if (\Auth::user()->isShop()) {
            $allowStatuses = [Status::STATUS_NEW, Status::STATUS_SENT];
            $users = User::where('shop_id', \Auth::user()->shop_id)->get();
            $query->where('shops.id', \Auth::user()->shop_id);
        }

        if (!\Auth::user()->isShop()) {
            if ($request->get('network_id')) {
                $query->where('networks.id', $request->get('network_id'));
            }

            if ($request->get('shop_id')) {
                $query->where('shops.id', $request->get('shop_id'));
            }
        }

        if ($request->get('user_id')) {
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

        if ($request->get('status_id')) {
            $query->where('status_id', $request->get('status_id'));
        }

        $buyRequests = $query->where('buyback_requests.is_deleted', false)->orderBy('id', 'DESC')->get();

        return view('cabinet.buyback_request.list',
            compact('buyRequests', 'statuses', 'shops', 'networks', 'users', 'allowStatuses'));
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
        if ($request->isMethod('post') && $request->get('id')) {

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
            $buyRequest->load('user', 'status', 'model');

            if ($buyRequest->wasChanged('status_id') && $buyRequest->status_id == Status::STATUS_SENT) {
                $admins = User::where('role_id', Role::ROLE_ADMIN)->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)
                        ->send(new RequestChangeStatusShipped($buyRequest));
                }
            }

            if ($buyRequest->wasChanged('status_id') && ($buyRequest->status_id == Status::STATUS_TAKE || $buyRequest->status_id == Status::STATUS_RETURN)) {
                Mail::to($buyRequest->user->email)
                    ->send(new RequestChangeStatusShipped($buyRequest));

            }

            $btnPay = (int) $request->get('status_id') === Status::STATUS_TAKE ? 1 : 0;

            return response(['status' => 1, 'btn_pay' => $btnPay, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $buyRequest]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function paid(Request $request)
    {
        $buyRequest = BuybackRequest::find($request->get('id'));

        if ($buyRequest) {
            if (!$buyRequest->is_paid && $buyRequest->is_accrued) {
                $buyRequest->is_paid = true;
                $buyRequest->paid_by = \Auth::id();
                $buyRequest->paid_at = Carbon::now();

                $buyRequest->save();

                return response(['status' => 1, 'type' => 'success', 'message' => "Бонус по заявке выплачен в размере {$buyRequest->bonus} грн!"]);
            }
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка, бонус не выплачен!']);
    }

    public function debt(Request $request)
    {
        $buyRequest = BuybackRequest::find($request->get('id'));

        if ($buyRequest) {
            if (!$buyRequest->is_debt) {
                $buyRequest->is_debt = true;
                $buyRequest->save();

                return response(['status' => 1, 'type' => 'success', 'message' => "Списана задолженность склада в размере {$buyRequest->cost} грн!"]);
            }
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка, при списании задолженности склада!']);
    }

    public function delete(Request $request)
    {
        $buyRequest = BuybackRequest::find($request->get('id'));

        if ($buyRequest) {
            $buyRequest->is_deleted = true;
            $buyRequest->save();

            return response(['status' => 1, 'type' => 'success', 'message' => "Заявка удалена!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }

    public function export(Request $request)
    {
        return Excel::download(
            new BuybackRequestExport($request),
            sprintf('requests %s.xlsx', Carbon::now()->format('Y-m-d H:i'))
        );
    }

    public function pdf(Request $request, $id)
    {
        $buyBackRequest = BuybackRequest::find($id);
        $network = $buyBackRequest->user->network;
         if ($network->name === 'Protoria') {
             $template = 'cabinet.buyback_request.pdf.protoria';
         } else {
             $template = 'cabinet.buyback_request.pdf.protoria';
         }
        $pdf = PDF::loadView($template, compact('buyBackRequest'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return view($template, compact('buyBackRequest'));
//        return $pdf->download(sprintf('Акт #%s %s.pdf', $buyBackRequest->id,  Carbon::now()->format('d.m.Y H:i')));
    }

    public function loadStock(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $queryNetwork = DB::table('buyback_requests')->select('networks.*')
                ->selectRaw('SUM(buyback_requests.cost) as debt')
                ->join('users', 'users.id', '=', 'buyback_requests.user_id')
                ->join('networks', 'networks.id', '=', 'users.network_id')
                ->where('buyback_requests.is_debt', false)
                ->groupBy('networks.id');

            $queryShops = DB::table('buyback_requests')->select('shops.*')
                ->selectRaw('SUM(buyback_requests.cost) as debt')
                ->join('users', 'users.id', '=', 'buyback_requests.user_id')
                ->leftJoin('shops', 'shops.id', '=', 'users.shop_id')
                ->where('buyback_requests.is_debt', false)
                ->where('shops.id', '<>', null)
                ->groupBy('shops.id');

            if (\Auth::user()->isNetwork()) {
                $queryNetwork->where('users.network_id', \Auth::user()->network_id);
                $queryShops->where('users.network_id', \Auth::user()->network_id);
            }

            if (\Auth::user()->isShop()) {
                $queryNetwork->where('users.shop_id', \Auth::user()->shop_id);
                $queryShops->where('users.shop_id', \Auth::user()->shop_id);
            }

            $debtNetworks = $queryNetwork->get();
            $debtShops = $queryShops->get();

            return view('cabinet.buyback_request.blocks.stock', compact('debtNetworks', 'debtShops'));
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка, не верный запрос!']);
    }
}
