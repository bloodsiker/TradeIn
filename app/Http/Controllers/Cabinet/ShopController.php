<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class ShopController
 */
class ShopController extends Controller
{

    public function list()
    {
        $shops = Shop::all()->sortByDesc('id');
        $networks = Network::all()->sortByDesc('id');

        return view('cabinet.shops.list', compact('shops', 'networks'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name'       => ['required', 'min:3', 'max:255'],
                'network_id' => ['required', 'numeric'],
            ]);

            $shop = new Shop();
            $shop->name = $request->get('name');
            $shop->network_id = $request->get('network_id');
            $shop->city = $request->get('city');
            $shop->address = $request->get('address');

            $shop->save();

            return redirect()->route('cabinet.shop.list')->with('success', 'Магазин добавлен!');
        }

        return redirect()->route('cabinet.shop.list');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $shop = Shop::find($request->get('id'));
            $shop->name = $request->get('name');
            $shop->network_id = $request->get('network_id');
            $shop->city = $request->get('city');
            $shop->address = $request->get('address');

            $shop->save();

            return redirect()->route('cabinet.shop.list')->with('success', 'Информация обновлена');
        }

        return redirect()->route('cabinet.shop.list')->with('danger', 'Ошибка при обновлении!');
    }

    public function delete(Request $request)
    {
        $shop = Shop::findOrFail($request->get('id'));

        if ($shop) {
            $shop->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Магазин {$shop->name} удален!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }

    public function users(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $users = User::where('shop_id', $shop->id)->orderBy('id', 'desc')->get();

        return view('cabinet.shops.users', compact('shop', 'users'));
    }
}
