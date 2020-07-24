<?php

namespace App\Http\Controllers\Cabinet;

use App\Exports\BuybackRequestExport;
use App\Facades\UserLog;
use App\Http\Controllers\Controller;
use App\Mail\RequestChangeStatusShipped;
use App\Models\BuybackBonus;
use App\Models\BuybackPacket;
use App\Models\BuybackRequest;
use App\Models\Network;
use App\Models\NovaPoshta;
use App\Models\Role;
use App\Models\Shop;
use App\Models\Status;
use App\Models\User;
use App\Repositories\Interfaces\BuybackRequestRepositoryInterface;
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
    /**
     * @var BuybackRequestRepositoryInterface
     */
    private $buybackRequestRepository;

    public function __construct(BuybackRequestRepositoryInterface $buybackRequestRepository)
    {
        $this->buybackRequestRepository = $buybackRequestRepository;
    }

    public function list(Request $request)
    {
        $statuses = Status::all();
        $allowStatuses = [];
        $shops = $networks = $users = [];
        $query = $this->buybackRequestRepository->baseQuery();

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

            $this->buybackRequestRepository->filterNetwork($query, \Auth::user()->network_id);
        }

        if (\Auth::user()->isShop()) {
            $allowStatuses = [Status::STATUS_NEW, Status::STATUS_SENT];
            $users = User::where('shop_id', \Auth::user()->shop_id)->get();
            $this->buybackRequestRepository->byUser($query, \Auth::user()->shop_id);
        }

        if (!\Auth::user()->isShop()) {
            if ($request->get('network_id')) {
                $this->buybackRequestRepository->filterNetwork($query, $request->get('network_id'));
            }

            if ($request->get('shop_id')) {
                $this->buybackRequestRepository->filterShop($query, $request->get('shop_id'));
            }
        }

        if ($request->get('user_id')) {
            $this->buybackRequestRepository->byUser($query, $request->get('user_id'));
        }

        if ($request->get('date_from') && $request->get('date_to')) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::parse($request->get('date_to'))->format('Y-m-d').' 23:59';
            $this->buybackRequestRepository->filterByDate($query, $from, $to);
        } elseif ($request->get('date_from') && empty($request->get('date_to'))) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::now()->format('Y-m-d').' 23:59';
            $this->buybackRequestRepository->filterByDate($query, $from, $to);
        }

        if ($request->get('status_id')) {
            $this->buybackRequestRepository->filterStatus($query, $request->get('status_id'));
        }

        $buyRequests = $query->where('buyback_requests.is_deleted', false)->orderBy('id', 'DESC')->get();

        return view('cabinet.buyback_request.list',
            compact('buyRequests', 'statuses', 'shops', 'networks', 'users', 'allowStatuses'));
    }

    public function packets(Request $request)
    {
        $query = BuybackPacket::select('buyback_packets.*');
        $query->join('users', 'users.id', '=', 'buyback_packets.user_id')
            ->leftJoin('shops', 'users.shop_id', '=', 'shops.id')
            ->leftJoin('networks', 'users.network_id', '=', 'networks.id');

        if (\Auth::user()->isNetwork()) {
            $query->where('networks.id', \Auth::user()->network_id);
        }

        if (\Auth::user()->isShop()) {
            $query->where('shops.id', \Auth::user()->shop_id);
        }

        $buyPackets = $query->orderBy('id', 'DESC')->get();

        return view('cabinet.buyback_request.packets.list',
            compact('buyPackets'));
    }

    public function packet(Request $request, $id)
    {
        $buyPacket = BuybackPacket::with('ttn')->find($id);

        $networks = Network::all();
        $shops = Shop::all();

        $query = $this->buybackRequestRepository->baseQuery();
        $this->buybackRequestRepository->filterStatus($query, Status::STATUS_NEW);

        $query->leftJoin('buyback_packet_request', 'buyback_packet_request.request_id', '=', 'buyback_requests.id')
            ->where('buyback_packet_request.packet_id', '=', null);

        if ($request->get('network_id')) {
            $this->buybackRequestRepository->filterNetwork($query, $request->get('network_id'));
        }

        if ($request->get('shop_id')) {
            $this->buybackRequestRepository->filterShop($query, $request->get('shop_id'));
        }

        if ($request->get('date_from') && $request->get('date_to')) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::parse($request->get('date_to'))->format('Y-m-d').' 23:59';
            $this->buybackRequestRepository->filterByDate($query, $from, $to);
        } elseif ($request->get('date_from') && empty($request->get('date_to'))) {
            $from = Carbon::parse($request->get('date_from'))->format('Y-m-d').' 00:00';
            $to = Carbon::now()->format('Y-m-d').' 23:59';
            $this->buybackRequestRepository->filterByDate($query, $from, $to);
        }

        $buyRequests = $query->where('buyback_requests.is_deleted', false)->orderBy('id', 'DESC')->get();

        return view('cabinet.buyback_request.packets.packet',
            compact('buyPacket', 'buyRequests', 'networks', 'shops'));
    }

    public function addPacket(Request $request)
    {
        if ($request->isMethod('post')) {

            $butPacket= new BuybackPacket();
            $butPacket->user_id = \Auth::id();
            $butPacket->name = $request->get('name');

            $butPacket->save();

            UserLog::log("Создал новый пакет {$butPacket->name}");

            return redirect()->route('cabinet.buyback_request.packets')->with('success', 'Пакет создан!');
        }

        return redirect()->route('cabinet.buyback_request.packets.list');
    }

    public function addToPacket(Request $request)
    {
        $buyPacket = BuybackPacket::find($request->get('packet'));

        $buyRequest = BuybackRequest::find($request->get('id'));

        if ($request->get('action') === 'addToPacket') {
            $buyPacket->requests()->attach($buyRequest);
            return view('cabinet.buyback_request.packets.packet_request_inline', compact('buyRequest', 'buyPacket'));

        } elseif ($request->get('action') === 'removeFromTtn') {
            $buyPacket->requests()->detach($buyRequest);
            $buyRequest->load('user', 'model', 'status');

            return view('cabinet.buyback_request.packets.packet_request_row', compact('buyRequest', 'buyPacket'));
        }

        return response(['status' => 1, 'type' => 'success', 'message' => "Добавленно к посылке!", 'data' => $data ?? null]);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $buyRequest = $this->buybackRequestRepository->add($request);

            UserLog::log("Создал заявку на выкуп 'ID#{$buyRequest->id}'");

            return response(['status' => 1, 'type' => 'success', 'message' => 'Ваша заявка на выкуп отправлена!']);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка приотправке заявки']);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->get('id')) {

            $buyRequest = $this->buybackRequestRepository->update($request);
            $buyRequest->load('user', 'status', 'model');

            UserLog::log("Изменил заявку на выкуп 'ID#{$buyRequest->id}'");

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

                UserLog::log("Сделал выплату бонуса по заявке на выкуп 'ID#{$buyRequest->id}'");

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

                UserLog::log("Списал долг склада по заявке на выкуп 'ID#{$buyRequest->id}' ");

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

            UserLog::log("Удалил заявку на выкуп 'ID#{$buyRequest->id}'");

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

        $pdf = PDF::loadView('cabinet.buyback_request.pdf.act', compact('buyBackRequest'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        UserLog::log("Сгенерировал АКТ ПРИЕМА-ПЕРЕДАЧИ по заявке 'ID#{$buyBackRequest->id}' ");

//        return view('cabinet.buyback_request.pdf.act', compact('buyBackRequest'));
        return $pdf->download(sprintf('Акт #%s %s.pdf', $buyBackRequest->id,  Carbon::now()->format('d.m.Y H:i')));
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
